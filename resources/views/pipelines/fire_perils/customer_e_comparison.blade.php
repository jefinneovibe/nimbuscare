
@extends('layouts.customer')
@include('includes.loader')
@section('content')
    <main class="layout_content">

        <!-- Main Content -->
        <div class="page_content">
            <div class="section_details">
                <div class="card_content">
                    <div class="edit_sec clearfix">

                        <div class="customer_header clearfix">
                            <div class="customer_logo">
                                <img src="{{URL::asset('img/main/interactive_logo.png')}}">
                            </div>
                            <h2>Proposal for Fire and Perils</h2>
                            <table class="customer_info table table-bordered" style="border: black solid">
                                <tr>
                                    <td height="20" style="border-right: 1px solid #ddd"><p style="font-size: 15px">Prepared for : <b>{{$pipeline_details['customer']['name']}}</b></p></td>
                                    <td height="20" style="border-right: 1px solid #ddd"><p style="font-size: 15px">Customer ID : <b>{{$pipeline_details['customer']['customerCode']}}</b></p></td>
                                    <td></td>
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
                        <input type="hidden" id="count" value="{{count($selectedId)}}">

                        <div class="data_table compare_sec">
                            <div id="admin">
                                <form id="approve_form" name="approve_form" method="post">
                                    {{csrf_field()}}
                                    <input class="not_hidden" type="hidden" id="pipeline_id" name="pipeline_id" value="{{$pipeline_details->_id}}">

                                <div class="material-table">


                                    <div class="table_fixed height_fix common_fix">
                                        <div class="table_sep_fix">
                                            <div class="material-table table-responsive" style="border-bottom: none;overflow: hidden">
                                                <table class="table table-bordered"  style="border-bottom: none">
                                            <thead>
                                            <tr>
                                                    <th><div class="main_question">Questions</div></th>
                                                </tr>
                                                </thead>
                                                <tbody style="border-bottom: none" class="syncscroll"  name="myElements">
                                                        @if($pipeline_details['formData']['saleClause'] == true)
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Sale of interest clause</label></div></td>
                                                        </tr>
                                                    @endif

                                                    @if($pipeline_details['formData']['fireBrigade'] == true)
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Fire brigade and extinguishing clause</label></div></td>
                                                        </tr>
                                                    @endif

                                                    @if($pipeline_details['formData']['clauseWording'] == true)
                                                        <tr> <td><div class="main_question"><label class="form_label bold">72 Hours clause-wording modified- the 72 hours will stretch beyond the expiration of the policy period provided
                                                                        the first earthquake/flood/storm occurred prior to the expiry time of the policy</label></div></td>                                                        
                                                                    </tr>
                                                    @endif

                                                    @if($pipeline_details['formData']['automaticReinstatement'] == true)
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Automatic reinstatement of sum insured at pro-rata additional premium</label></div></td>
                                                        </tr>
                                                    @endif

                                                    @if($pipeline_details['formData']['capitalClause'] == true)
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Capital addition clause</label></div></td>
                                                        </tr>
                                                    @endif

                                                    @if($pipeline_details['formData']['mainClause'] == true)
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Workmen’s Maintenance clause</label></div></td>
                                                        </tr>
                                                    @endif

                                                    @if($pipeline_details['formData']['repairCost'] == true)
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Repair investigation costs</label></div></td>
                                                        </tr>
                                                    @endif

                                                    @if($pipeline_details['formData']['debris'] == true)
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Removal of debris</label></div></td>
                                                        </tr>
                                                    @endif

                                                    @if($pipeline_details['formData']['reinstatementValClass'] == true)
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Reinstatement Value  clause (85% condition of  average)</label></div></td>
                                                        </tr>
                                                    @endif

                                                    @if($pipeline_details['formData']['waiver'] == true)
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Waiver  of subrogation (against affiliates and subsidiaries)</label></div></td>
                                                        </tr>
                                                    @endif

                                                    @if($pipeline_details['formData']['trace'] == true)
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Trace and Access Clause</label></div></td>
                                                        </tr>
                                                    @endif

                                                    @if($pipeline_details['formData']['publicClause'] == true)
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Public authorities clause</label></div></td>
                                                        </tr>
                                                    @endif

                                                    @if($pipeline_details['formData']['contentsClause'] == true)
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">All other contents clause</label></div></td>
                                                        </tr>
                                                    @endif

                                                    @if($pipeline_details['formData']['errorOmission'] == true)
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Errors & Omissions</label></div></td>
                                                        </tr>
                                                    @endif

                                                    @if($pipeline_details['formData']['alterationClause'] == true)
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Alteration and use  clause</label></div></td>
                                                        </tr>
                                                    @endif
                                                    
                                                    @if($pipeline_details['formData']['tempRemovalClause'] == true)
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Temporary removal clause</label></div></td>
                                                            
                                                        </tr>
                                                    @endif
                                                   

                                                    @if($pipeline_details['formData']['proFee'] == true)
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Professional fees clause</label></div></td>
                                                            
                                                        </tr>
                                                    @endif

                                                    @if($pipeline_details['formData']['expenseClause'] == true)
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Expediting expense clause</label></div></td>
                                                            
                                                        </tr>
                                                    @endif

                                                    @if($pipeline_details['formData']['desigClause'] == true)
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Designation of property clause</label></div></td>
                                                            
                                                        </tr>
                                                    @endif

                                                    @if($pipeline_details['formData']['buildingInclude'] == true && $pipeline_details['formData']['buildingInclude']!='')
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Adjoining building clause</label></div></td>
                                                        </tr>
                                                    @endif

                                                    @if($pipeline_details['formData']['cancelThirtyClause'] == true)
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Cancellation clause-30 days either party subject to pro-rata refund of premium in either case unless a claim attached</label></div></td>
                                                        </tr>
                                                    @endif

                                                    @if($pipeline_details['formData']['primaryInsuranceClause'] == true)
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Primary insurance clause</label></div></td>
                                                        </tr>
                                                    @endif

                                                    @if($pipeline_details['formData']['paymentAccountClause'] == true)
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Payment on account clause</label></div></td>
                                                        </tr>
                                                    @endif

                                                    @if($pipeline_details['formData']['nonInvalidClause'] == true)
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Non-invalidation clause</label></div></td>
                                                        </tr>
                                                    @endif


                                                    @if($pipeline_details['formData']['warrantyConditionClause'] == true)
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Breach of warranty or condition clause</label></div></td>
                                                        </tr>
                                                    @endif

                                                    @if($pipeline_details['formData']['escalationClause'] == true)
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Escalation clause</label></div></td>
                                                        </tr>
                                                    @endif

                                                    @if($pipeline_details['formData']['addInterestClause'] == true)
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Additional Interest Clause</label></div></td>
                                                        </tr>
                                                    @endif

                                                    @if(isset($pipeline_details['formData']['stock']) && $pipeline_details['formData']['stock']!='')

                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Stock Declaration clause</label></div></td>
                                                        </tr>
                                                    @endif

                                                    @if($pipeline_details['formData']['improvementClause'] == true)
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Improvement and betterment clause</label></div></td>
                                                        </tr>
                                                    @endif

                                                    @if($pipeline_details['formData']['automaticClause'] == true)
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Automatic Addition deletion clause to be notified within 30 days period</label></div></td>
                                                        </tr>
                                                    @endif

                                                    @if($pipeline_details['formData']['reduseLoseClause'] == true)
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Expense to reduce the loss clause</label></div></td>
                                                        </tr>
                                                    @endif

                                                    @if($pipeline_details['formData']['buildingInclude']!='' && $pipeline_details['formData']['demolitionClause'] == true)
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Demolition clause</label></div></td>
                                                        </tr>
                                                    @endif

                                                    @if($pipeline_details['formData']['noControlClause'] == true)
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">No control clause</label></div></td>
                                                        </tr>
                                                    @endif

                                                    @if($pipeline_details['formData']['preparationCostClause'] == true)
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Claims preparation cost clause</label></div></td>
                                                        </tr>
                                                    @endif

                                                    @if($pipeline_details['formData']['coverPropertyCon'] == true)
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Cover for property lying in the premises in containers</label></div></td>
                                                        </tr>
                                                    @endif

                                                    @if($pipeline_details['formData']['personalEffectsEmployee'] == true)
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Personal effects of employee</label></div></td>
                                                        </tr>
                                                    @endif

                                                    @if($pipeline_details['formData']['incidentLandTransit'] == true)
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Incidental Land Transit </label></div></td>
                                                        </tr>
                                                    @endif

                                                    @if($pipeline_details['formData']['lossOrDamage'] == true)
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Including loss or damage due to subsidence, ground heave or landslip</label></div></td>
                                                        </tr>
                                                    @endif

                                                    @if($pipeline_details['formData']['nominatedLossAdjusterClause'] == true)
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Nominated Loss Adjuster clause-Insured can select the loss surveyor out of a panel – John Kidd LA, Cunningham Lindsey, & Miller International</label></div></td>
                                                        </tr>
                                                    @endif

                                                    @if($pipeline_details['formData']['sprinkerLeakage'] == true)
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Sprinkler leakage clause</label></div></td>
                                                        </tr>
                                                    @endif

                                                    @if($pipeline_details['formData']['minLossClause'] == true)
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Minimization of loss clause</label></div></td>
                                                        </tr>
                                                    @endif


                                                    @if($pipeline_details['formData']['costConstruction'] == true)
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Increased cost of construction</label></div></td>
                                                        </tr>
                                                    @endif

                                                    @if($pipeline_details['formData']['annualRent'] && $pipeline_details['formData']['annualRent'] != '')
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Loss of rent</label></div></td>
                                                        </tr>
                                                    @endif

                                                    @if($pipeline_details['formData']['propertyValuationClause'] == true)
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Property Valuation clause</label></div></td>
                                                        </tr>
                                                    @endif

                                                    @if($pipeline_details['formData']['accidentalDamage'] == true)
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Including accidental damage to plate glass, interior and exterior signs</label></div></td>
                                                        </tr>
                                                    @endif

                                                    @if($pipeline_details['formData']['auditorsFee'] == true)
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Auditor’s fee</label></div></td>
                                                        </tr>
                                                    @endif

                                                    @if($pipeline_details['formData']['smokeSoot'] == true)
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Smoke and Soot damage extension</label></div></td>
                                                        </tr>
                                                    @endif

                                                    @if($pipeline_details['formData']['boilerExplosion'] == true)
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Boiler explosion extension</label></div></td>
                                                        </tr>
                                                    @endif

                                                    @if($pipeline_details['formData']['chargeAirfreight'] == true)
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Extra charges for airfreight</label></div></td>
                                                        </tr>
                                                    @endif

                                                    @if($pipeline_details['formData']['tempRemoval'] == true)
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Temporary repair clause</label></div></td>
                                                        </tr>
                                                    @endif

                                                    @if($pipeline_details['formData']['strikeRiot'] == true)
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Strike riot and civil commotion clause</label></div></td>
                                                        </tr>
                                                    @endif

                                                    @if($pipeline_details['formData']['coverMechanical'] == true)
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Cover for  mechanical, electrical and electronic breakdown  for fixed non-mobile plant and machinery</label></div></td>
                                                        </tr>
                                                    @endif

                                                    @if($pipeline_details['formData']['coverExtWork'] == true)
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Cover for external works including sign boards,  landscaping  including trees in building</label></div></td>
                                                        </tr>
                                                    @endif

                                                    @if($pipeline_details['formData']['misdescriptionClause'] == true)
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Misdescription Clause</label></div></td>
                                                        </tr>
                                                    @endif
                                                   

                                                    @if($pipeline_details['formData']['otherInsuranceClause'] == true)
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Other insurance allowed clause</label></div></td>
                                                        </tr>
                                                    @endif

                                                    @if($pipeline_details['formData']['automaticAcqClause'] == true)
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Automatic acquisition clause</label></div></td>
                                                        </tr>
                                                    @endif

                                                    @if(@$pipeline_details['formData']['occupancy']['type']=='Residence' || @$pipeline_details['formData']['occupancy']['type']=='Labour Camp')
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Cover for alternative accomodation</label></div></td>
                                                        </tr>
                                                    @endif

                                                    @if($pipeline_details['formData']['businessType'])
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Cover for exhibition risks</label></div></td>
                                                        </tr>
                                                    @endif

                                                    @if(@$pipeline_details['formData']['occupancy']['type']=='Warehouse'
                                                        ||  @$pipeline_details['formData']['occupancy']['type']=='Factory'
                                                        ||  @$pipeline_details['formData']['occupancy']['type']=='Others')
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Cover for property in the open</label></div></td>
                                                        </tr>
                                                    @endif

                                                    @if($pipeline_details['formData']['otherItems']!='')
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Including property in the care, custody & control of the insured</label></div></td>
                                                        </tr>
                                                    @endif

                                                    @if($pipeline_details['formData']['minorWorkExt'] == true)
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Minor works extension</label></div></td>
                                                        </tr>
                                                    @endif

                                                    @if($pipeline_details['formData']['saleInterestClause'] == true)
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Sale of Interest Clause   </label></div></td>                                                     </label></div></td>
                                                        </tr>
                                                    @endif

                                                    @if($pipeline_details['formData']['sueLabourClause'] == true)
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Sue and labour clause</label></div></td>
                                                        </tr>
                                                    @endif

                                                    @if($pipeline_details['formData']['bankPolicy']['bankPolicy'] == true)
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Loss payee clause</label></div></td>
                                                        </tr>
                                                    @endif

                                                    @if($pipeline_details['formData']['electricalClause'] == true)
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Electrical clause waiver- Loss or damage by fire to electrical or electronic appliances ,
                                                                        installations and wiring insured by this policy arising from or occasioned by over running, overheating excessive current, short circuiting,
                                                                        arcing, self-heating or leakage of electricity from whatever cause (lightning included) is covered</label></div></td>
                                                        </tr>
                                                    @endif

                                                    @if($pipeline_details['formData']['contractPriceClause'] == true)
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Contract price clause</label></div></td>
                                                        </tr>
                                                    @endif

                                                    @if($pipeline_details['formData']['sprinklerUpgradationClause'] == true)
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Sprinkler upgradation clause</label></div></td>
                                                        </tr>
                                                    @endif

                                                    @if($pipeline_details['formData']['accidentalFixClass'] == true)
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Accidental damage to fixed glass, glass (other than fixed glass)</label></div></td>
                                                        </tr>
                                                    @endif

                                                    @if($pipeline_details['formData']['electronicInstallation'] == true)
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Electronic installation, computers, data processing, equipment and other fragile or brittle object</label></div></td>
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
                                                        </tr>
                                                    @endif

                                                    @if($pipeline_details['formData']['brandTrademark'] == true)
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Brand and trademark</label></div></td>
                                                        </tr>
                                                    @endif

                                                    @if($pipeline_details['formData']['ownerPrinciple']==true)
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Indemnity to owners and principals</label></div></td>
                                                        </tr>
                                                    @endif

                                                    @if($pipeline_details['formData']['conductClause'] == true)
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Conduct of business clause</label></div></td>
                                                        </tr>
                                                    @endif

                                                    @if($pipeline_details['formData']['lossNotification'] == true)
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Loss Notification – ‘as soon as reasonably practicable</label></div></td>
                                                        </tr>
                                                    @endif

                                                    @if($pipeline_details['formData']['brockersClaimClause'] == true)
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Brokers Claim Handling Clause :
                                                                        A loss notification received by the Insurance Broker will be deemed as a loss notification to Insurer.
                                                                        All communications flowing between the Insurer, Insured and the appointed Loss Surveyor should be channelized through the Broker,
                                                                        unless there is any unavoidable reasons compelling direct communications between the parties</label></div></td>
                                                        </tr>
                                                    @endif

                                                @if($pipeline_details['formData']['businessInterruption']['business_interruption'] ==true )
                                                    @if($pipeline_details['formData']['addCostWorking'] == true)
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Additional increase in cost of working</label></div></td>
                                                        </tr>
                                                    @endif

                                                    @if($pipeline_details['formData']['claimPreparationClause'] == true)
                                                            <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Claims preparation clause</label></div></td>
                                                        </tr>
                                                    @endif

                                                    @if($pipeline_details['formData']['suppliersExtension'] == true)
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Suppliers extension/customer extension</label></div></td>
                                                        </tr>
                                                    @endif

                                                    @if($pipeline_details['formData']['accountantsClause'] == true)
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Accountants clause</label></div></td>
                                                        </tr>
                                                    @endif

                                                    @if($pipeline_details['formData']['accountPayment'] == true)
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Payment on account</label></div></td>
                                                        </tr>
                                                    @endif

                                                    @if($pipeline_details['formData']['preventionDenialClause'] == true)
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Prevention/denial of access</label></div></td>
                                                        </tr>
                                                    @endif

                                                    @if($pipeline_details['formData']['premiumAdjClause'] == true)
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Premium adjustment clause</label></div></td>
                                                        </tr>
                                                    @endif

                                                    @if($pipeline_details['formData']['publicUtilityClause'] == true)
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Public utilities clause</label></div></td>
                                                        </tr>
                                                    @endif

                                                    @if($pipeline_details['formData']['brockersClaimHandlingClause'] == true)
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Brokers Claim Handling Clause : A loss notification received by the
                                                                        Insurance Broker will be deemed as a loss notification to Insurer. All communications flowing between the Insurer, Insured and
                                                                        the appointed Loss Surveyor should be channelized through the Broker,
                                                                        unless there is any unavoidable reasons compelling direct communications between the parties</label></div></td>
                                                        </tr>
                                                    @endif

                                                    @if($pipeline_details['formData']['accountsRecievable'] == true)
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Accounts recievable / Loss of booked debts</label></div></td>
                                                        </tr>
                                                    @endif

                                                    @if($pipeline_details['formData']['interDependency'] == true)
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Interdependany clause</label></div></td>
                                                        </tr>
                                                    @endif

                                                    @if($pipeline_details['formData']['extraExpense'] == true)
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Extra expense</label></div></td>
                                                        </tr>
                                                    @endif

                                                    @if($pipeline_details['formData']['contaminatedWater'] == true)
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Contaminated water</label></div></td>
                                                        </tr>
                                                    @endif

                                                    @if($pipeline_details['formData']['expenseReduceLoss'] == true)
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Expense to reduce the loss</label></div></td>
                                                        </tr>
                                                    @endif

                                                    @if($pipeline_details['formData']['auditorsFeeCheck'] == true)
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Auditors fees</label></div></td>
                                                        </tr>
                                                    @endif

                                                    @if($pipeline_details['formData']['nominatedLossAdjuster'] == true)
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Nominated loss adjuster</label></div></td>
                                                        </tr>
                                                    @endif

                                                    @if($pipeline_details['formData']['outbreakDiscease'] == true)
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Outbreak of discease</label></div></td>
                                                        </tr>
                                                    @endif

                                                    @if($pipeline_details['formData']['nonPublicFailure'] == true)
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Failure of non public power supply</label></div></td>
                                                        </tr>
                                                    @endif

                                                    @if($pipeline_details['formData']['premisesDetails'] == true)
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Murder, Suicide or outbreak of discease on the premises</label></div></td>
                                                        </tr>
                                                    @endif

                                                    @if($pipeline_details['formData']['bombscare'] == true)
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Bombscare and unexploded devices on the premises</label></div></td>
                                                        </tr>
                                                    @endif

                                                    @if($pipeline_details['formData']['DenialClause'] == true)
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Denial of access</label></div></td>
                                                        </tr>
                                                    @endif

                                                    @if($pipeline_details['formData']['bookDebits'] == true)
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Book of Debts</label></div></td>
                                                        </tr>
                                                    @endif

                                                    @if($pipeline_details['formData']['publicFailure'] == true)
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Failure of public utility</label></div></td>
                                                        </tr>
                                                    @endif

                                                    @if(isset($pipeline_details['formData']['businessInterruption']['noLocations']) && $pipeline_details['formData']['businessInterruption']['noLocations']>1)

                                                        @if($pipeline_details['formData']['departmentalClause'] == true)
                                                            <tr>
                                                                <td><div class="main_question"><label class="form_label bold">Departmental clause</label></div></td>
                                                            </tr>
                                                        @endif
                                                        @if($pipeline_details['formData']['rentLease'] == true)
                                                            <tr>
                                                                <td><div class="main_question"><label class="form_label bold">Rent & Lease hold interest</label></div></td>
                                                            </tr>
                                                        @endif
                                                    @endif


                                                    @if($pipeline_details['formData']['CoverAccomodation']['coverAccomodation'] == true)
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Cover for alternate accomodation</label></div></td>
                                                        </tr>
                                                    @endif

                                                    @if($pipeline_details['formData']['demolitionCost'] == true)
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Demolition and increased cost of construction</label></div></td>
                                                        </tr>
                                                    @endif

                                                    @if($pipeline_details['formData']['contingentBusiness'] == true)
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Contingent business inetruption and contingent extra expense</label></div></td>
                                                        </tr>
                                                    @endif

                                                    @if($pipeline_details['formData']['nonOwnedProperties'] == true)
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Non Owned property in vicinity interuption</label></div></td>
                                                        </tr>
                                                    @endif

                                                    @if($pipeline_details['formData']['royalties'] == true)
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Royalties</label></div></td>
                                                        </tr>
                                                    @endif

                                                @endif



                                                    @if(isset($pipeline_details['formData']['cliamPremium']) &&
                                                        $pipeline_details['formData']['cliamPremium'] =='combined_data')

                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Deductible for Property</label></div></td>
                                                        </tr>
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Deductible for Business Interruption</label></div></td>
                                                        </tr>
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Rate (combined)</label></div></td>
                                                        </tr>
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Premium (combined)</label></div></td>
                                                        </tr>
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Brokerage (combined)</label></div></td>
                                                        </tr>
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Warranty (Property)</label></div></td>
                                                        </tr>
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Warranty (Business Interruption)</label></div></td>
                                                        </tr>
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Exclusion (Property)</label></div></td>
                                                        </tr>
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Exclusion (Business Interruption)</label></div></td>
                                                        </tr>
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Special Condition (Property)</label></div></td>
                                                        </tr>
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Special Condition (Business Interruption)</label></div></td>
                                                        </tr>


                                                    @endif

                                                    @if(isset($pipeline_details['formData']['cliamPremium']) &&
                                                        $pipeline_details['formData']['cliamPremium'] =='only_fire')

                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Deductible</label></div></td>
                                                        </tr>

                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Rate </label></div></td>
                                                        </tr>
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Premium </label></div></td>
                                                        </tr>
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Brokerage </label></div></td>
                                                        </tr>
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Warranty </label></div></td>
                                                        </tr>

                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Exclusion </label></div></td>
                                                        </tr>
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Special Condition</label></div></td>
                                                        </tr>


                                                    @endif

                                                    @if(isset($pipeline_details['formData']['cliamPremium']) &&
                                                        $pipeline_details['formData']['cliamPremium'] =='separate_fire')

                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Deductible for Property</label></div></td>
                                                        </tr>

                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Rate (Property)</label></div></td>
                                                        </tr>
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Premium (Property)</label></div></td>
                                                        </tr>
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Brokerage (Property)</label></div></td>
                                                        </tr>
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Warranty (Property)</label></div></td>
                                                        </tr>
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Exclusion (Property)</label></div></td>
                                                        </tr>
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Special Condition (Property)</label></div></td>
                                                        </tr>

                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Deductible for Business Interruption</label></div></td>
                                                        </tr>

                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Rate (Business Interruption)</label></div></td>
                                                        </tr>
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Premium (Business Interruption)</label></div></td>
                                                        </tr>
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Brokerage (Business Interruption)</label></div></td>
                                                        </tr>
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Warranty (Business Interruption)</label></div></td>
                                                        </tr>
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Exclusion (Business Interruption)</label></div></td>
                                                        </tr>
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Special Condition (Business Interruption)</label></div></td>
                                                        </tr>
                                                    @endif

                                                    <tr>
                                                        <td><div class="main_question"><label class="form_label bold">YOUR DECISION  <span>*</span></label><div class="height_align" style="display: none"></div></div></td>
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
                                                                                                data-container="body" data-original-title="{{$insures_details[$i]['accountsRecievable']['comment']}}"></i> --}}
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
                                                                        <td><div class="ans">
                                                                            <textarea class="form_input {{$insures_details[$i]['uniqueToken']}}" name="text_{{$insures_details[$i]['uniqueToken']}}" placeholder="Comments..." id="{{$insures_details[$i]['uniqueToken']}}"></textarea>
                                                                            <div class="form_group">
                                                                                <div class="cntr">
                                                                                    <label for="approve_{{$insures_details[$i]['uniqueToken']}}" class="radio {{$insures_details[$i]['uniqueToken']}}">
                                                                                        <input type="radio" name="{{$insures_details[$i]['uniqueToken']}}" value="Approved" id="approve_{{$insures_details[$i]['uniqueToken']}}" class="hidden {{$insures_details[$i]['uniqueToken']}}" onchange="checkApprove(this)">
                                                                                        <span class="label"></span>
                                                                                        <span>Approve</span>
                                                                                    </label>
                                                                                    <label for="reject_{{$insures_details[$i]['uniqueToken']}}" class="radio {{$insures_details[$i]['uniqueToken']}}">
                                                                                        <input type="radio" name="{{$insures_details[$i]['uniqueToken']}}" value="Rejected" id="reject_{{$insures_details[$i]['uniqueToken']}}" class="hidden {{$insures_details[$i]['uniqueToken']}}" onchange="notApprove(this)">
                                                                                        <span class="label"></span>
                                                                                        <span>Reject</span>
                                                                                    </label>
                                                                                    <label for="amend_{{$insures_details[$i]['uniqueToken']}}" class="radio {{$insures_details[$i]['uniqueToken']}}">
                                                                                        <input type="radio" name="{{$insures_details[$i]['uniqueToken']}}" value="Requested for amendment" id="amend_{{$insures_details[$i]['uniqueToken']}}" class="hidden {{$insures_details[$i]['uniqueToken']}}" onchange="notApprove(this)">
                                                                                        <span class="label"></span>
                                                                                        <span>Amend</span>
                                                                                    </label>
                                                                                </div>
                                                                            </div>
                                                                            <div  class="reason_show" id="select_reson_{{$insures_details[$i]['uniqueToken']}}" style="display:none">
                                                                                    <label class="form_label">Select reason <span>*</span></label>
                                                                                    <div class="custom_select">
                                                                                            <select class="form_input process" name="reason_{{$insures_details[$i]['uniqueToken']}}" id="process_drop_{{$insures_details[$i]['uniqueToken']}}" onchange="messageCheck(this)">
                                                                                                <option value="">Select reason</option>
                                                                                                <option value="Another insurance company required">Another insurance company required </option>
                                                                                                <option value="Close the case">Close the case </option>                                                                                      
                                                                                            </select>
                                                                                    </div>
                                                                                <label id="process_drop_{{$insures_details[$i]['uniqueToken']}}-error" class="error" style="display:none" for="process_drop_{{$insures_details[$i]['uniqueToken']}}">Please select reason</label>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                    @endif
                                                                @endfor
                                                        </tr>
                                                    
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                    </div>


                                </div>
                                    <label id="decision-error" class="error pull-right" style="display: none;width: 100%;margin: 8px 0;">Please select a decision.</label>
                                    <div class="clearfix" style="margin-top: 20px;">

                                        <button class="btn btn-primary pull-right" type="button" onclick="formSubmit()">Proceed</button>

                                        <p style="float: left;width: 80%;font-size: 13px;font-weight: 500;line-height: 17px;font-style: italic;margin: 4px 0;">IMPORTANT: This document is the property of INTERACTIVE Insurance Brokers LLC, Dubai and is
                                            strictly confidential to its recipients. The document should not be copied, distributed or
                                            reproduced in whole or in part, nor passed to any third party without the consent of its owner.
                                        </p>
                                    </div>
                                </form>
                            </div>



                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <style>
        .section_details{
            max-width: 100%;
        }
        .material-table table.comparison th{
            width: 310px;
        }
        .page_content {
            top: 0px;
            height: 100%;
        }
        .radio .label {
            width: 17px;
            height: 17px;
            margin-top: 2px;
        }
        .radio .label:after {
            width: 7px;
            height: 7px;
        }
        .cntr span:last-child{
            font-size: 12px;
        }
        .section_details .card_content {
            padding: 20px;
            margin-bottom: 0;
        }
        .height_fix tbody {
            height: calc(100vh - 362px);
        }
    </style>

@endsection
@push('scripts')
    {{--JQUERY VALIDATOR--}}
    <script src="{{\Illuminate\Support\Facades\URL::asset('js/main/jquery.validate.js')}}"></script>
    <script src="{{\Illuminate\Support\Facades\URL::asset('js/main/custom-select.js')}}"></script>

    <script>
        var flag = 0;
        $(document).ready(function(){
            $('#btn_reject').on('click', function(){
                $('#preLoader').show();
            });
        });
        function messageCheck(obj1)
        {
           var  valueExist=obj1.value;
            if(valueExist == ''){
                $('#'+obj1.id+'-error').show();
            }else{
                $('#'+obj1.id+'-error').hide();
            }
        }
        function checkApprove(obj)
        {
            jQuery("input, textarea")
                .not("."+obj.name)
                .not(".not_hidden")
                .removeAttr("checked", "checked").attr("disabled", "disabled");
            $('#decision-error').hide();
            flag = 1;
            $('#select_reson_'+obj.name).hide();
            $('.reason_show').hide();
            $('.height_align').hide();
            $('#process_drop_'+obj.name).attr("required",false);
            $('.process').prop("required",false);
        }
        function notApprove(obj) {
            if(obj.value=='Rejected')
            {
                $('#select_reson_'+obj.name).show();
                $('.height_align').show();
                $('#process_drop_'+obj.name+'-error').html("Please select the reason"); 
                $('#process_drop_'+obj.name).attr("required",true);   
            }else{
                $('#select_reson_'+obj.name).hide();
                $('.height_align').hide();
                $('#process_drop_'+obj.name).attr("required",false);
            }
            jQuery("input, textarea")
                .removeAttr("disabled", "disabled");
            var count = $('#count').val();
            if($('input[type=radio]:checked').length==count)
            {
                $('#decision-error').hide();
            }
        }
        $('#approve_form').validate({
            ignore:[],
            rules:{},
            submitHandler: function (form,event) {
                var form_data = new FormData($("#approve_form")[0]);
                form_data.append('_token',"{{csrf_token()}}");
                $('#preLoader').fadeIn('slow');
                $.ajax({
                    method: 'post',
                    url: '{{url('customer-save')}}',
                    data: form_data,
                    cache : false,
                    contentType: false,
                    processData: false,
                    success:function (data) {
                        if(data == 'success')
                        {
                            location.href = "{{url('customer-notification')}}";
                        }
                    }
                });
            }
        });
        function formSubmit()
        {
            if(flag == 0)
            {
                var count = $('#count').val();
                if($('input[type=radio]:checked').length==count)
                {
                    $('#approve_form').submit();
                }
                else
                {
                    $('#decision-error').show();
                }
            }
            else if(flag == 1)
            {
                $('#approve_form').submit();
            }
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
        $.validator.messages.required = "Please select the reason";

    </script>

    <script src="{{URL::asset('js/syncscroll.js')}}"></script>

@endpush
