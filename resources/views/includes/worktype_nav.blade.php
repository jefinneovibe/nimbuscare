<style>
.col-none {
    padding-left:15px !important;
}
</style>
@if (! Request::is('excel-imported-list'))
                <!-- Sidebar  -->
            <nav id="sidebar">

                    <ul class="list-unstyled components">
                        <li {{ Request::is('equestionnaire/'.@$workTypeDataId) ? 'class=active' : '' }} >
                            <a href="{{url('equestionnaire/'.@$workTypeDataId)}}">E-Questionnaire
                            @if(count(@$formValues['eQuestionnaire']) >= 4)<i class="fa fa-check green menutick" aria-hidden="true"></i> @endif
                            </a>
                        </li>


                        @if($formValues['status']['status'] == 'Worktype Created' || $formValues['status']['status'] == 'E-questionnaire' || !isset($formValues['eQuestinareStatus']))
                        <li><a href="#">E-Slip</a></li>
                        @else
                        <li {{ Request::is('eslip/'.@$workTypeDataId) ? 'class=active' : '' }}>
                            <a href="{{ url('eslip/'.@$workTypeDataId)}}">E-Slip
                            @if(!empty(@$formValues['eSlip']))<i class="fa fa-check green menutick" aria-hidden="true"></i> @endif
                            </a>
                        </li>
                        @endif

                        @if(@$formValues['status']['status'] == 'Worktype Created' || @$formValues['status']['status'] == 'E-questionnaire' || @$formValues['status']['status'] == 'E-slip')
                            
                        <li>
                        @if(@$formValues['status']['status'] == 'E-slip'&& isset($formValues['insurerList']) && count($formValues['insurerList']) > 0)
                        <a href="{{url('equotation/'.@$workTypeDataId)}}">E-Quotation
                        <i class="fa fa-check green menutick" aria-hidden="true"></i>
                        @else
                        <a href="#">E-Quotation
                        @endif
                        </a></li>
                        @else
                        <li {{ Request::is('equotation/'.@$workTypeDataId) ? 'class=active' : '' }}>
                            <a href="{{url('equotation/'.@$workTypeDataId)}}">E-Quotation
                            @if(isset($formValues['insurerList']) && count($formValues['insurerList']) > 0)
                            <i class="fa fa-check green menutick" aria-hidden="true"></i>
                            @endif
                            </a>
                        </li>
                        @endif

                        @if(@$formValues['status']['status'] == 'Worktype Created' || @$formValues['status']['status'] == 'E-questionnaire' || @$formValues['status']['status'] == 'E-slip' || @$formValues['status']['status'] == 'E-quotation')
                        <li><a href="#">E-Comparison</a></li>
                        @else
                        <li {{ Request::is('ecomparison/'.@$workTypeDataId) ? 'class=active' : '' }}>
                            <a href="{{url('ecomparison/'.@$workTypeDataId)}}">E-Comparison
                            @if(@$formValues['status']['status'] == 'Quote Amendment' || @$formValues['status']['status'] == 'Approved E Quote' || @$formValues['status']['status'] == 'Quote Amendment-E-quotation'|| @$formValues['status']['status'] == 'Quote Amendment-E-comparison')
                                <i class="fa fa-check green menutick" aria-hidden="true"></i>
                            @endif
                        </a>

                        </li>
                        @endif

                        @if(@$formValues['status']['status'] == 'Worktype Created' || @$formValues['status']['status'] == 'E-questionnaire' || @$formValues['status']['status'] == 'E-slip' || @$formValues['status']['status'] == 'E-quotation' || @$formValues['status']['status'] == 'E-comparison')
                        <li><a href="#">Quote Amendment</a></li>
                        @else
                        <li {{ Request::is('quote-amendment/'.@$workTypeDataId) ? 'class=active' : '' }}>
                            <a href="{{url('quote-amendment/'.@$workTypeDataId)}}">Quote Amendment
                            @if(@$formValues['status']['status'] == 'Quote Amendment' || @$formValues['status']['status'] == 'Approved E Quote' || @$formValues['status']['status'] == 'Quote Amendment-E-quotation'|| @$formValues['status']['status'] == 'Quote Amendment-E-comparison')
                            <i class="fa fa-check green menutick" aria-hidden="true"></i>
                            @endif
                        </a>

                        </li>
                        @endif

                        @if(@$formValues['status']['status'] == 'Worktype Created' || @$formValues['status']['status'] == 'E-questionnaire' || @$formValues['status']['status'] == 'E-slip' || @$formValues['status']['status'] == 'E-quotation' || @$formValues['status']['status'] == 'E-comparison' || @$formValues['status']['status'] == 'Quote Amendment'|| @$formValues['status']['status'] == 'Quote Amendment-E-quotation'|| @$formValues['status']['status'] == 'Quote Amendment-E-comparison')
                        <li><a href="#">Approved E-Quote</a></li>
                        @else
                        <li {{ Request::is('approved-equote/'.@$workTypeDataId) ? 'class=active' : '' }}>
                            <a href="{{url('approved-equote/'.@$workTypeDataId)}}">Approved E-Quote
                            <!-- <i class="fa fa-check green menutick" aria-hidden="true"></i>  -->
                        </a>
                        </li>
                        @endif
                    </ul>
                </nav>
            <!--sidebar ends-->
          @endif
