
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
    <?php $pipeline_details = $PipelineItems ?>
    <div class="section_details">
        <div class="card_header clearfix">
            <h3 class="title" style="margin-bottom: 8px;">Employers Liability</h3>
        </div>
        <div class="card_content">
            <form id="e_quest_form" name="e_quest_form" method="post" enctype="multipart/form-data">
                {{csrf_field()}}
               <?php $url=URL::previous();
	            $set_value=0;
	            if (strpos($url, 'e-slip') !== false) {
		            $set_value=1;
	            }
	            else{
		            $set_value=0;
                }
	            ?>
                <input type="hidden" value="{{$eQuestionnaireid}}" id="id" name="id">
                <input type="hidden" value="fill_underwriter" id="filler_type" name="filler_type">
                <input type="hidden" @if($form_data) value="1" @else value="0" @endif  id="is_edit" name="is_edit">
                <input type="hidden" id="pipeline_id" name="pipeline_id" value="{{$eQuestionnaireid}}">
                @if(session('message'))
                    <input type="hidden" value="success" id="success">
                @else
                    <input type="hidden" value="failed" id="success">
                @endif
            <div class="edit_sec clearfix">

                <!-- Steps -->
                <section>
                    <nav>
                        <ol class="cd-breadcrumb triangle">
                            @if(($PipelineItems['status']['status']=='E-questionnaire')|| ($PipelineItems['status']['status']=='Worktype Created'))
                                <li class="current"><em>E-Questionnaire</em></li>
                                <li><em>E-Slip</em></li>
                                <li><em>E-quotation</em></li>
                                <li><em>E-Comparison</em></li>
                                <li><em>Quote Amendment</em></li>
                                <li><em>Approved E Quote</em></li>
                                {{--<li><em>Issuance</em></li>--}}
                            @elseif($PipelineItems['status']['status']=='E-slip')
                                <li class="active_arrow"><em>E-Questionnaire</em></li>
                                <li class="current"><a href="{{url('employer/e-slip/'.$eQuestionnaireid)}}" style="color: #ffffff;"><em>E-Slip</em></a></li>
                                <li><em>E-quotation</em></li>
                                <li><em>E-Comparison</em></li>
                                <li><em>Quote Amendment</em></li>
                                <li><em>Approved E Quote</em></li>
                                {{--<li><em>Issuance</em></li>--}}
                            @elseif($PipelineItems['status']['status']=='E-quotation')
                                <li class="active_arrow"><em>E-Questionnaire</em></li>
                                <li class="complete"><a href="{{url('employer/e-slip/'.$eQuestionnaireid)}}" style="color: #ffffff;"><em>E-Slip</em></a></li>
                                <li class="current"><a href="{{url('employer/e-quotation/'.$eQuestionnaireid)}}" style="color: #ffffff;"><em>E-quotation</em></a></li>
                                <li><em>E-Comparison</em></li>
                                <li><em>Quote Amendment</em></li>
                                <li><em>Approved E Quote</em></li>
                                {{--<li><em>Issuance</em></li>--}}
                            @elseif($PipelineItems['status']['status']=='E-comparison')
                                <li class="active_arrow"><em>E-Questionnaire</em></li>
                                <li class="complete"><a href="{{url('employer/e-slip/'.$eQuestionnaireid)}}" style="color: #ffffff;"><em>E-Slip</em></a></li>
                                <li class="complete"><a href="{{url('employer/e-quotation/'.$eQuestionnaireid)}}" style="color: #ffffff;"><em>E-quotation</em></a></li>
                                <li class="current"><a href="{{url('employer/e-comparison/'.$eQuestionnaireid)}}" style="color: #ffffff;"><em>E-Comparison</em></a></li>
                                <li><em>Quote Amendment</em></li>
                                <li><em>Approved E Quote</em></li>
                                {{--<li><em>Issuance</em></li>--}}
                            @elseif($PipelineItems['status']['status']=='Approved E Quote')
                                <li class="active_arrow"><em>E-Questionnaire</em></li>
                                <li class="complete"><a href="{{url('employer/e-slip/'.$eQuestionnaireid)}}" style="color: #ffffff;"><em>E-Slip</em></a></li>
                                <li class="complete"><a href="{{url('employer/e-quotation/'.$eQuestionnaireid)}}" style="color: #ffffff;"><em>E-quotation</em></a></li>
                                <li class="complete"><a href="{{url('employer/e-comparison/'.$eQuestionnaireid)}}" style="color: #ffffff;"><em>E-Comparison</em></a></li>
                                <li class="complete"><a href="{{url('employer/quot-amendment/'.$eQuestionnaireid)}}" style="color: #ffffff;"><em>Quote Amendment</em></a></li>
                                <li class="current"><a href="{{url('employer/approved-quot/'.$eQuestionnaireid)}}" style="color: #ffffff;"><em>Approved E Quote</em></a></li>
                                {{--<li><em>Issuance</em></li>--}}
                            @elseif($PipelineItems['status']['status']=='Quote Amendment')
                                <li class="active_arrow"><em>E-Questionnaire</em></li>
                                <li class="complete"><a href="{{url('employer/e-slip/'.$eQuestionnaireid)}}" style="color: #ffffff;"><em>E-Slip</em></a></li>
                                <li class="complete"><a href="{{url('employer/e-quotation/'.$eQuestionnaireid)}}" style="color: #ffffff;"><em>E-quotation</em></a></li>
                                <li class="complete"><a href="{{url('employer/e-comparison/'.$eQuestionnaireid)}}" style="color: #ffffff;"><em>E-Comparison</em></a></li>
                                <li class="current"><a href="{{url('employer/quot-amendment/'.$eQuestionnaireid)}}" style="color: #ffffff;"><em>Quote Amendment</em></a></li>
                                <li><em>Approved E Quote</em></li>
                                {{--<li><em>Issuance</em></li>--}}
                            @elseif($pipeline_details['status']['status'] == 'Quote Amendment-E-comparison' || $pipeline_details['status']['status'] == 'Quote Amendment-E-quotation' || $pipeline_details['status']['status'] == 'Quote Amendment-E-slip')
                                <li class="active_arrow"><em>E-Questionnaire</em></li>
                                <li class="complete"><a href="{{url('employer/e-slip/'.$eQuestionnaireid)}}" style="color: #ffffff;"><em>E-Slip</em></a></li>
                                <li class="complete"><a href="{{url('employer/e-quotation/'.$eQuestionnaireid)}}" style="color: #ffffff;"><em>E-quotation</em></a></li>
                                <li class="complete"><a href="{{url('employer/e-comparison/'.$eQuestionnaireid)}}" style="color: #ffffff;"><em>E-Comparison</em></a></li>
                                <li class="current"><a href="{{url('employer/quot-amendment/'.$eQuestionnaireid)}}" style="color: #ffffff;"><em>Quote Amendment</em></a></li>
                                <li><em>Approved E Quote</em></li>
                            {{--@elseif($PipelineItems['status']['status']=='Issuance')--}}
                                {{--<li class="complete"><em>E-Questionnaire</em></li>--}}
                                {{--<li class="complete"><a href="{{url('e-slip/'.$eQuestionnaireid)}}" style="color: #ffffff;"><em>E-Slip</em></a></li>--}}
                                {{--<li class="complete"><a href="{{url('e-quotation/'.$eQuestionnaireid)}}" style="color: #ffffff;"><em>E-quotation</em></a></li>--}}
                                {{--<li class="complete"><a href="{{url('e-comparison/'.$eQuestionnaireid)}}" style="color: #ffffff;"><em>E-Comparison</em></a></li>--}}
                                {{--<li class="complete"><a href="{{url('quot-amendment/'.$eQuestionnaireid)}}" style="color: #ffffff;"><em>Quote Amendment</em></a></li>--}}
                                {{--<li class="complete"><a href="{{url('approved-quot/'.$eQuestionnaireid)}}" style="color: #ffffff;"><em>Approved E Quote</em></a></li>--}}
                                {{--<li class="current"><a href="{{url('issuance/'.$eQuestionnaireid)}}" style="color: #ffffff;"><em>Issuance</em></a></li>--}}
                            @else
                                <li class="current"><em>E-Questionnaire</em></li>
                                <li><em>E-Slip </em></li>
                                <li><em>E-quotation</em></li>
                                <li><em>E-Comparison</em></li>
                                <li><em>Quote Amendment</em></li>
                                <li><em>Approved E Quote</em></li>
                                {{--<li><em>Issuance</em></li>--}}

                            @endif
                        {{--</ol> <ol class="cd-breadcrumb triangle">--}}
                            {{--@if(($PipelineItems['status']['status']=='E-questionnaire')|| ($PipelineItems['status']['status']=='Worktype Created'))--}}
                                {{--<li class="complete"><em>E-Questionnaire</em></li>--}}
                                {{--<li class="current"><a href="{{url('e-slip/'.$eQuestionnaireid)}}" style="color: #ffffff;"><em>E-Slip</em></a></li>--}}
                                {{--<li><em>E-quotation</em></li>--}}
                                {{--<li><em>E-Comparision</em></li>--}}
                                {{--<li><em>Quote Ammendment</em></li>--}}
                                {{--<li><em>Approved E Quote</em></li>--}}
                                {{--<li><em>Issuance</em></li>--}}
                            {{--@elseif($PipelineItems['status']['status']=='E-slip')--}}
                                {{--<li class="complete"><em>E-Questionnaire</em></li>--}}
                                {{--<li class="complete"><a href="{{url('e-slip/'.$eQuestionnaireid)}}" style="color: #ffffff;"><em>E-Slip</em></a></li>--}}
                                {{--<li class="current"><a href="{{url('e-quotation/'.$eQuestionnaireid)}}" style="color: #ffffff;"><em>E-quotation</em></a></li>--}}
                                {{--<li><em>E-Comparision</em></li>--}}
                                {{--<li><em>Quote Ammendment</em></li>--}}
                                {{--<li><em>Approved E Quote</em></li>--}}
                                {{--<li><em>Issuance</em></li>--}}
                            {{--@elseif($PipelineItems['status']['status']=='E-quotation')--}}
                                {{--<li class="complete"><em>E-Questionnaire</em></li>--}}
                                {{--<li class="complete"><a href="{{url('e-slip/'.$eQuestionnaireid)}}" style="color: #ffffff;"><em>E-Slip</em></a></li>--}}
                                {{--<li class="complete"><a href="{{url('e-quotation/'.$eQuestionnaireid)}}" style="color: #ffffff;"><em>E-quotation</em></a></li>--}}
                                {{--<li class="current"><a href="{{url('e-comparison/'.$eQuestionnaireid)}}" style="color: #ffffff;"><em>E-Comparision</em></a></li>--}}
                                {{--<li><em>Quote Ammendment</em></li>--}}
                                {{--<li><em>Approved E Quote</em></li>--}}
                                {{--<li><em>Issuance</em></li>--}}
                            {{--@elseif($PipelineItems['status']['status']=='Approved E Quote')--}}
                                {{--<li class="complete"><em>E-Questionnaire</em></li>--}}
                                {{--<li class="complete"><a href="{{url('e-slip/'.$eQuestionnaireid)}}" style="color: #ffffff;"><em>E-Slip</em></a></li>--}}
                                {{--<li class="complete"><a href="{{url('e-quotation/'.$eQuestionnaireid)}}" style="color: #ffffff;"><em>E-quotation</em></a></li>--}}
                                {{--<li class="complete"><a href="{{url('e-comparison/'.$eQuestionnaireid)}}" style="color: #ffffff;"><em>E-Comparision</em></a></li>--}}
                                {{--<li class="complete"><a href="{{url('quot-amendment/'.$eQuestionnaireid)}}" style="color: #ffffff;"><em>Quote Amendment</em></a></li>--}}
                                {{--<li class="current"><a href="{{url('approved-quot/'.$eQuestionnaireid)}}" style="color: #ffffff;"><em>Approved E Quote</em></a></li>--}}
                                {{--<li><em>Issuance</em></li>--}}
                            {{--@elseif($PipelineItems['status']['status']=='Quote Ammendment')--}}
                                {{--<li class="complete"><em>E-Questionnaire</em></li>--}}
                                {{--<li class="complete"><a href="{{url('e-slip/'.$eQuestionnaireid)}}" style="color: #ffffff;"><em>E-Slip</em></a></li>--}}
                                {{--<li class="complete"><a href="{{url('e-quotation/'.$eQuestionnaireid)}}" style="color: #ffffff;"><em>E-quotation</em></a></li>--}}
                                {{--<li class="complete"><a href="{{url('e-comparison/'.$eQuestionnaireid)}}" style="color: #ffffff;"><em>E-Comparision</em></a></li>--}}
                                {{--<li class="current"><a href="{{url('quot-amendment/'.$eQuestionnaireid)}}" style="color: #ffffff;"><em>Quote Amendment</em></a></li>--}}
                                {{--<li><em>Approved E Quote</em></li>--}}
                                {{--<li><em>Issuance</em></li>--}}
                            {{--@elseif($PipelineItems['status']['status']=='Issuance')--}}
                                {{--<li class="complete"><em>E-Questionnaire</em></li>--}}
                                {{--<li class="complete"><a href="{{url('e-slip/'.$eQuestionnaireid)}}" style="color: #ffffff;"><em>E-Slip</em></a></li>--}}
                                {{--<li class="complete"><a href="{{url('e-quotation/'.$eQuestionnaireid)}}" style="color: #ffffff;"><em>E-quotation</em></a></li>--}}
                                {{--<li class="complete"><a href="{{url('e-comparison/'.$eQuestionnaireid)}}" style="color: #ffffff;"><em>E-Comparision</em></a></li>--}}
                                {{--<li class="complete"><a href="{{url('quot-amendment/'.$eQuestionnaireid)}}" style="color: #ffffff;"><em>Quote Amendment</em></a></li>--}}
                                {{--<li class="complete"><a href="{{url('approved-quot/'.$eQuestionnaireid)}}" style="color: #ffffff;"><em>Approved E Quote</em></a></li>--}}
                                {{--<li class="current"><a href="{{url('issuance/'.$eQuestionnaireid)}}" style="color: #ffffff;"><em>Issuance</em></a></li>--}}
                            {{--@else--}}
                                {{--<li class="current"><em>E-Questionnaire</em></li>--}}
                                {{--<li><em>E-Slip </em></li>--}}
                                {{--<li><em>E-quotation</em></li>--}}
                                {{--<li><em>E-Comparision</em></li>--}}
                                {{--<li><em>Quote Amendment</em></li>--}}
                                {{--<li><em>Approved E Quote</em></li>--}}
                                {{--<li><em>Issuance</em></li>--}}

                            {{--@endif--}}
                        </ol>
                    </nav>
                </section>

                @include('forms.emp_liability.e_questionnaire_form')
                <?php
                    if(@$PipelineItems['files']){
                        $other_documents = @$PipelineItems['files'];
                        $preview_divs = '';
                        foreach ($other_documents as $other_document) {
                            if($other_document['url']!='' && @$other_document['upload_type']=='e_questionnaire_fancy'){
                                $preview_divs .= '<tr class=""><td class="ff_fileupload_preview"><img class="ff_fileupload_preview_image ff_fileupload_preview_image_has_preview" type="button"aria-label="Preview" src='.$other_document['url'].'><span class="ff_fileupload_preview_text"></span></button><div class="ff_fileupload_actions_mobile"><button class="ff_fileupload_remove_file" type="button" aria-label="Remove from list" style="display: inline-block;"></button></div></td><td class="ff_fileupload_summary"><div class="ff_fileupload_filename">'.$other_document['file_name'].'</div><div class="ff_fileupload_fileinfo">Uploaded</div><div class="ff_fileupload_errors ff_fileupload_hidden"></div><div class="ff_fileupload_progress_background ff_fileupload_hidden"><div class="ff_fileupload_progress_bar" style="width: 100%;"></div></div></td><td class="ff_fileupload_actions"><button class="ff_fileupload_remove_file btnDelete" type="button" aria-label="Remove from list"></button><input class="saved_url" type="hidden" value="'.$other_document['url'].'" id="other_document_saved[]" name="other_document_saved[]"><input type="hidden" value="'.$other_document['file_name'].'" id="other_document_saved_name[]" name="other_document_saved_name[]"></td></tr>';
                            }
                        }
                    }

                ?>
                {{--<div class="row">--}}
                    {{--<div class="col-md-12">--}}
                        {{--<div class="form_group">--}}
                            {{--<label class="form_label">Any Comments <span style="visibility: hidden">*</span></label>--}}
                            {{--<textarea class="form_input" name="comments" placeholder="Comments..."></textarea>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</div>--}}
                <div class="clearfix">
                <button class="btn btn-primary btn_action pull-right" id="button_submit" type="button">Proceed</button>
                <button class="btn btn-primary btn_action pull-right" name="button_upload" id="button_upload"  style="display:none;background-color: #4cae4c" type="button">Uploading ..</button>
                @if(@$PipelineItems['status']['status']!="Approved E Quote")
                <button type="button" data-modal="questionnaire_popup" class="btn blue_btn btn_action pull-right" id="btn-send">Send to Customer</button>
                @endif
                <button type = "button" class="btn blue_btn pull-right btn_action" id="qs_save">Save as Draft</button>
                </div>
            </div>
            </form>
        </div>
    </div>




    <div id="upload_popup">
        <div class="cd-popup">
            <div class="cd-popup-container">
                <div class="modal_content">
                    <h1>File Upload</h1>
                    <div class="clearfix"></div>
                    <div class="content_spacing">
                        <div class="row">
                            <div class="col-md-12">
                                <p>Upload or Remove the files from list before proceeding the application.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal_footer">
                    <button class="btn btn-primary btn-link btn_cancel">Ok</button>
                </div>
            </div>
        </div>
    </div>

    <div id="active_upload_popup">
        <div class="cd-popup">
            <div class="cd-popup-container">
                <div class="modal_content">
                    <h1>File Upload</h1>
                    <div class="clearfix"></div>
                    <div class="content_spacing">
                        <div class="row">
                            <div class="col-md-12">
                                <p>There is a file upload still in progress.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal_footer">
                    <button class="btn btn-primary btn-link btn_cancel">Ok</button>
                </div>
            </div>
        </div>
    </div>

    @include('includes.mail_popup')
    @include('includes.chat')
@endsection

@push('scripts')
    <!--jquery validate-->
 <script src="{{URL::asset('js/main/jquery.validate.js')}}"></script>
 <script src="{{URL::asset('js/main/additional-methods.min.js')}}"></script>
 <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>
<!-- Custom Select -->
<script src="{{URL::asset('js/main/custom-select.js')}}"></script>

<!-- Bootstrap Select -->
<script src="{{URL::asset('js/main/bootstrap-select.js')}}"></script>

<!-- Date Picker -->
<script src="{{URL::asset('js/main/bootstrap-datetimepicker.js')}}"></script>


<!-- Fancy FileUpload -->
<script src="{{URL::asset('js/file-uploader/jquery.ui.widget.js')}}"></script>
<script src="{{URL::asset('js/file-uploader/jquery.fileupload.js')}}"></script>
<script src="{{URL::asset('js/file-uploader/jquery.iframe-transport.js')}}"></script>
<script src="{{URL::asset('js/file-uploader/jquery.fancy-fileupload.js')}}"></script>

<script>
    {{--var currentRequest=null;--}}
    {{--//        $('#countryName').selectpicker();--}}
    {{--$(document).on('keyup', '.countryDiv .bs-searchbox input', function () {--}}
        {{--var searchData = $(this).val();--}}
        {{--currentRequest = jQuery.ajax({--}}
            {{--type: "POST",--}}
            {{--url: "{{url('get-countries-name')}}",--}}
            {{--data:{searchData :searchData, _token : '{{csrf_token()}}'},--}}
            {{--beforeSend : function()    {--}}
                {{--if(currentRequest != null) {--}}
                    {{--currentRequest.abort();--}}
                {{--}--}}
            {{--},--}}
            {{--success: function(data) {--}}
                {{--$('#countryName').html(data.response_country);--}}
                {{--$('#countryName').selectpicker('refresh');--}}

                {{--$('#countryName-error').hide();--}}
            {{--}--}}
        {{--});--}}

    {{--});--}}


    {{--var currentRequest1=null;--}}
    {{--//        $('#countryName').selectpicker();--}}
    {{--$(document).on('keyup', '.placeCountry .bs-searchbox input', function () {--}}
        {{--var searchData = $(this).val();--}}
        {{--currentRequest1 = jQuery.ajax({--}}
            {{--type: "POST",--}}
            {{--url: "{{url('get-countries-name')}}",--}}
            {{--data:{searchData :searchData, _token : '{{csrf_token()}}'},--}}
            {{--beforeSend : function()    {--}}
                {{--if(currentRequest1 != null) {--}}
                    {{--currentRequest1.abort();--}}
                {{--}--}}
            {{--},--}}
            {{--success: function(data) {--}}
                {{--$('#country1').html(data.response_country);--}}
                {{--$('#country1').selectpicker('refresh');--}}

                {{--$('#country1-error').hide();--}}
            {{--}--}}
        {{--});--}}

    {{--});--}}
    {{----}}
    {{--$('#country1').selectpicker();--}}
    {{--$(document).on('keyup', '.countryDiv .bs-searchbox input', function (e) {--}}
        {{--var searchData = $(this).val();--}}
        {{--$.ajax({--}}
            {{--type: "POST",--}}
            {{--url: "{{url('get-countries-name')}}",--}}
            {{--data:{searchData :searchData, _token : '{{csrf_token()}}'},--}}
            {{--success: function(data){--}}

                {{--$('#country1').html(data.response_country);--}}
                {{--$('#country1-error').hide();--}}
            {{--}--}}
        {{--});--}}

        {{--$('#country1').selectpicker('refresh');--}}
    {{--});--}}

    {{--$('#countryName').selectpicker();--}}
    {{--$(document).on('keyup', '.placeCountry .bs-searchbox input', function (e) {--}}
        {{--var searchData = $(this).val();--}}
        {{--$.ajax({--}}
            {{--type: "POST",--}}
            {{--url: "{{url('get-countries-name')}}",--}}
            {{--data:{searchData :searchData, _token : '{{csrf_token()}}'},--}}
            {{--success: function(data){--}}
                {{--$('#countryName').html(data.response_country);--}}
                {{--$('#countryName-error').hide();--}}
            {{--}--}}
        {{--});--}}

        {{--$('#countryName').selectpicker('refresh');--}}
    {{--});--}}

    var mod =0;
    var file_length=0;
    $( "#button_submit" ).click(function() {
        var valid=  $("#e_quest_form").valid();
        if(valid==true) {
            $( "#button_submit" ).attr('disabled',true);
            $( "#btn-send" ).attr('disabled',true);
            $( "#qs_save" ).attr('disabled',true);
            var queued =$('.quest_file_upload').find('.ff_fileupload_queued').length;
            $('.quest_file_upload').find('.ff_fileupload_remove_file').hide();

            var arraylen = queued;
            if (arraylen != 0) {
                file_length = arraylen;
                $('#documents').next().find('.ff_fileupload_actions button.ff_fileupload_start_upload').click();
                return false;
            }
            else {
                $('#e_quest_form').submit();
            }
        }
    });

    $( "#qs_save" ).click(function() {
        $( "#button_submit" ).attr('disabled',true);
        $( "#btn-send" ).attr('disabled',true);
        $( "#qs_save" ).attr('disabled',true);
        mod = 1;
            $('#btn-send').hide();
            var queued =$('.quest_file_upload').find('.ff_fileupload_queued').length;
            $('.quest_file_upload').find('.ff_fileupload_remove_file').hide();

            var arraylen = queued;
            if (arraylen != 0) {
                file_length = arraylen;
                $('#documents').next().find('.ff_fileupload_actions button.ff_fileupload_start_upload').click();
                return false;
            }
            else {
                saveQuestionnaire();
            }

    });
    var initialDate;
    $(function () {
        $(window).load(function() {
            $('#preLoader').fadeOut('slow');
            localStorage.clear();
        });
    });
    jQuery.validator.addMethod("greaterThan",
        function(value, element, params) {
            var from = $(params).val().split("/");
            var fromDate = new Date(from[2], from[1] - 1, from[0]);
            var to = $('#policyTo').val().split("/");
            var toDate = new Date(to[2], to[1] - 1, to[0])
            if( toDate>fromDate)
            {
                return toDate>fromDate;
            }
        },'Must be greater than policy from date.');
    jQuery.validator.addMethod("cuttentOrFuture",
        function(value, element, params) {
            var from = $(params).val().split("/");
            var fromDate = new Date(from[2], from[1] - 1, from[0]);
            var d = new Date();
            var strDate = d.getDate() + "/" + (d.getMonth()+1) + "/" + d.getFullYear();
            var current = strDate.split("/");
            var currentDate = new Date(current[2], current[1] - 1, current[0]);
            if(fromDate>=currentDate)
            {
                return fromDate>=currentDate;
            }
        },'Must be greater than policy from date.');
    var output_url = [];
    var output_file = [];
    var cnt=0;
    $(function() {
        $('#documents').FancyFileUpload({

            params : {
                action : 'fileuploader'
            },
            maxfilesize : 1000000,
            url: '{{url('worktype-fileupload')}}', method: 'post',
            uploadcompleted: function (e, data) {
                output_url.push(data.result.file_url);
                output_file.push(data.result.file_name);
                file_length--;
//                this.find('.ff_fileupload_remove_file').show();
                if (file_length == 0) {
//                        $("#active_upload_popup .cd-popup").removeClass('is-visible');
                    if(mod == 1)
                    {
                        saveQuestionnaire()
                    }
                    else
                    {
                        $('#e_quest_form').submit();
                    }

                }
            }
//            edit : false,
//            maxfilesize : 1000000,
//             added : function(e, data) {
//                 // It is okay to simulate clicking the start upload button.
//                 this.find('.ff_fileupload_actions button.ff_fileupload_start_upload').click();
//                 $("#button_upload").show();
//                 $("#button_submit").hide();
//                 this.find('.ff_fileupload_remove_file').hide();
// //                $('.ff_fileupload_remove_file').hide();
//                 cnt++;
//             }
        });
    });

    var new_num;
    $("input.number").keyup(function(event){

        //   debugger;
        var $this = $(this);
        var num =  $this.val();
        var num_parts = num.toString().split(".");
        
        if(num_parts[1]){
        
                if(num_parts[1].length >2){
                    num2 = new_num;
                
                } else{
                    num_parts[0] = num_parts[0].replace(/,/gi, "");
                    num_parts[0] = num_parts[0].split(/(?=(?:\d{3})+$)/).join(",");
                    var num2 = num_parts.join(".");
                    new_num = num2;
                    
                }
        
            
        } else{
            num_parts[0] = num_parts[0].replace(/,/gi, "");
            num_parts[0] = num_parts[0].split(/(?=(?:\d{3})+$)/).join(",");
            var num2 = num_parts.join(".");
            new_num = num2;
        
        }
        $this.val(num2);

    });


//function setAmountValidation(value,id) {
//
//
//    if(value!='')
//    {
//        var amout= value.replace(/^\d+(,\d+)*$/);
//        if (isNaN( amout )) {
//            $('#'+id+'-error').show();
//            return false;
//        } else {
//            $('#'+id+'-error').hide();
//            return true;
//        }
////                return /^\d+(,\d+)$/.test(value);
//    }
//}
    jQuery.validator.addMethod("dropdown_required", function(value, element) {
        if(value!='') {
            return true;
        } else {
            return false;
        }
        // allow any non-whitespace characters as the host part
//        return this.optional( element ) || /^[a-zA-Z0-9.!#$%&'*+\/=?^_`{|}~-]+@(?:\S{1,63})$/.test( value );
    }, 'Please select this field.');


        //form validation
    $('#e_quest_form').validate({
        ignore: [],
        rules: {
            currentInsurer:{
                dropdown_required: function () {
                    return ($("#option_select2").val() =='existing_policy');
                }
            },
            salutation: {
                required: true
            },
            firstName: {
                required: true
            },
            lastName: {
                required: true
            },
            addressLine1: {
                required: true
            },
            country: {
                required: true
            },
            state: {
                required: true
            },
            city: {
                required: true
            },
            zipCode: {
                required: true
            },
            businessType: {
                required: true
            },
            hasExistingPolicy: {
                required: true
            },
            policyFrom: {
                required: true
            },
//            policyTo: {
//                required: true
//            },
            hasAdmin: {
                required: true
            },
            work_labour: {
                required: true
            },
            taxRegistrationDocument: {
                required: function () {
                    return ($("#tax_registation_url").val() == undefined);
                },
                accept: "image/jpg,image/jpeg,image/png,application/pdf,application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"
            },

            tradeLicense: {
                required: function () {
                    return ($("#trade_license_url").val() == undefined);
                },
                accept: "image/jpg,image/jpeg,image/png,application/pdf,application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"
            },
            policyCopy: {
                accept: "image/jpg,image/jpeg,image/png,application/pdf,application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"
            },
            existingRate: {
                required:function () {
                    return ($("#option_select2").val() =='existing_policy');
                },
            accept: "image/jpg,image/jpeg,image/png,application/pdf,application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
                number:true
            },
            withinUAE: {
                required: true
            },
            offshore: {
                required: true
            },
            listOfEmployees: {
                required: function () {
                    return ($("#employee_list_url").val() == undefined);
                }
            },
            emirateName: {
                required:function () {
                    return ($("#option_select3").val() =='WithinUAE');
                }
            },
            countryName: {
                required:function () {
                    return ($("#option_select3").val() =='OutsideUAE');
                }
            },
            adminCount: {
                required:function () {
                    return ($("#option_select4").val() =='admin_employees');
                },
                number:true
            },
            adminAnnualWages: {
                required:function () {
                    return ($("#option_select4").val() =='admin_employees');
                }
            },
            nonAdminCount: {
                required:function () {
                    return ($("#option_select4").val() =='non_admin_employees');
                },
                number:true
            },
            nonAdminAnnualWages: {
                required:function () {
                    return ($("#option_select4").val() =='non_admin_employees');
                },
                number:true
            },
            bothAdminCount: {
                required:function () {
                    return ($("#option_select4").val() =='both_employees');
                },
                number:true
            },
            bothNonAdminCount: {
                required:function () {
                    return ($("#option_select4").val() =='both_employees');
                },
                number:true
            },
            bothAdminAnnualWages: {
                required:function () {
                    return ($("#option_select4").val() =='both_employees');
                },
                number:true
            },
            bothNonAdminAnnualWages: {
                required:function () {
                    return ($("#option_select4").val() =='both_employees');
                },
                number:true
            },
            noOfLabourers: {
                required:function () {
                    return ($("#option_select5").val() =='hired_workers');
                },
                number:true
            },
            annualWages: {
                required:function () {
                    return ($("#option_select5").val() =='hired_workers');
                },
                number:true
            },
            offshoreNoOfLabourers: {
                required:function () {
                    return ($("#option_select6").val() =='offshore_employees');
                },
                number:true
            },
            offshoreAnnualWages: {
                required:function () {
                    return ($("#option_select6").val() =='offshore_employees');
                },
                number:true
            },
            policyTo: {
                greaterThan: "#policyFrom",
                required:true
            },
            'minor_claim_amount[]': {
                number:true
            },
            'death_claim_amount[]': {
                number:true
            },
            'file_upload_text[]': "required"
        },
        messages: {
            country: "Please select the country.",
            state: "Please select the emirates.",
            salutation: "Please select salutation.",
            firstName: "Please enter first name.",
            zipCode: "Please enter valid pin/zip .",
            lastName: "Please enter last name.",
            policyCopy: "Please upload valid file.(.png,.jpeg,.jpg,.pdf,.xls)",
            mainGroup: "Please select main group.",
            hasExistingPolicy: "Please select the policy status.",
            existingRate: "Please enter existing rate.",
            currentInsurer: "Please enter current insurer.",
            withinUAE: "Please select the place of employment.",
            emirateName: "Please select the emirate name.",
            countryName: "Please select the country name.",
            hasAdmin: "Please select the category.",
            adminCount: "Please enter admin count.",
            adminAnnualWages: "Please enter admin annual wages.",
            nonAdminCount: "Please enter non admin count.",
            nonAdminAnnualWages: "Please enter non admin annual wages.",
            bothAdminCount: "Please enter admin count.",
            bothNonAdminCount: "Please enter non admin count.",
            bothAdminAnnualWages: "Please enter admin annual wages.",
            bothNonAdminAnnualWages: "Please enter non admin annual wages.",
            work_labour: "Please select employees hiring status.",
            noOfLabourers: "Please enter no.of labourers.",
            annualWages: "Please enter annual wages.",
            offshore: "Please select the offshore employees status.",
            offshoreNoOfLabourers: "Please enter no.of employees.",
            offshoreAnnualWages: "Please enter annual wages.",
            policyFrom: "Please select policy from date.",
            policyTo: "Please select policy to date.",
            agent: "Please select the agent.",
            addressLine1: "Please enter address line 1.",
            city: "Please enter the city.",
            businessType: "Please select the business type.",
            taxRegistrationDocument: "Please upload valid registration document.(.png,.jpeg,.jpg,.pdf,.xls)",
            listOfEmployees: "Please upload valid list of  employees.(.png,.jpeg,.jpg,.pdf,.xls)",
            tradeLicense: "Please upload valid trade license document.(.png,.jpeg,.jpg,.pdf,.xls)",
            'contactNumber[]':"Please enter valid contact number",
            'email[]':"Please enter valid email id",
            'file_upload_text[]': "Please enter file name"
        },
        errorPlacement: function (error, element) {
            if(element.attr("name") == "taxRegistrationDocument"
                || element.attr("name") == "tradeLicense" || element.attr("name") == "listOfEmployees" ||
                element.attr("name") == "state" )
            {
                error.insertAfter(element.parent());

                var errorDiv = $('.error:visible').first();
                var scrollPos = errorDiv.offset().top;
                $(window).scrollTop(scrollPos);
            }
            else if(element.attr("name") == "country"
                || element.attr("name") == "businessType" || element.attr("name") == "hasExistingPolicy" ||
                element.attr("name") == "withinUAE" || element.attr("name") == "hasAdmin"
                || element.attr("name") == "work_labour"|| element.attr("name") == "offshore" ||
                element.attr("name") == "file_upload_text[]")
            {
                error.insertAfter(element.parent());

                var errorDiv = $('.error:visible').first();
                var scrollPos = errorDiv.offset().top;
                $(window).scrollTop(scrollPos);
            }
            else {
                error.insertAfter(element);

                var errorDiv = $('.error:visible').first();
                var scrollPos = errorDiv.offset().top;
                $(window).scrollTop(scrollPos);
            }
        },

        submitHandler: function (form,event) {
            /*
            * validation for fancy file upload(not uploaded files in list and uploading active files)
            * */
//            var queued = $('.ff_fileupload_queued');
//            var active = $('.ff_fileupload_uploading, .ff_fileupload_starting');
//            if (queued.length){
//                $("#upload_popup .cd-popup").toggleClass('is-visible');
//                return false;
//            }
//            if (active.length){
//                $("#active_upload_popup .cd-popup").toggleClass('is-visible');
//                return false;
//            }
            var form_data = new FormData($("#e_quest_form")[0]);
            form_data.append('output_url',output_url);
            form_data.append('output_file',output_file);
            form_data.append('_token', '{{csrf_token()}}');
            $('#preLoader').show();
            $("#button_submit").attr( "disabled", "disabled" );
            $.ajax({
                method: 'post',
                url: '{{url('employer/equestionnaire-save')}}',
                data: form_data,
                cache : false,
                contentType: false,
                processData: false,
                success: function (result) {
                    if (result== 'success') {
                        window.location.href = '{{url('employer/e-slip/'.$eQuestionnaireid)}}';
                    }
                }
            });
        }
     });
    function scrolltop()
    {
        $('html,body').animate({
            scrollTop: 150
        }, 0);
    }
//    function getClaimHistory(emp_category)
//    {
//        var emp_category = $('#'+option_select4).val();
//
//        if (emp_category ==admin_employees)
//        {
//            $( "#description1" ).rules( "add" , "required" );
//            $( "#minor_claim_amount1" ).rules( "add" , "required" );
//            $( "#death_claim_amount1" ).rules( "add" , "required" );
//        }
//        else if(emp_category == non_admin_employees)
//        {
//            $( "#description2" ).rules( "add" , "required" );
//            $( "#minor_claim_amount2" ).rules( "add" , "required" );
//            $( "#death_claim_amount2" ).rules( "add" , "required" );
//        }
//        else if(emp_category == both_employeess)
//        {
//            $( "#description1" ).rules( "add" , "required" );
//            $( "#minor_claim_amount1" ).rules( "add" , "required" );
//            $( "#death_claim_amount1" ).rules( "add" , "required" );
//            $( "#description2" ).rules( "add" , "required" );
//            $( "#minor_claim_amount2" ).rules( "add" , "required" );
//            $( "#death_claim_amount2" ).rules( "add" , "required" );
//        }
////        else
////        {
////            $( "#amount_paid" ).rules( "add" , "required" );
////            $( "#amount_due" ).rules( "add" , "required" );
////            $( "#sponsor_name" ).rules( "remove" , "required" );
////        }
//    }
    $(document).ready(function() {

        {{--$.ajax({--}}
            {{--type: "POST",--}}
            {{--url: "{{url('get-countries-name')}}",--}}
            {{--data:{ _token : '{{csrf_token()}}'},--}}
            {{--success: function(data) {--}}
{{--//                $('#countryName').html(data.response_country);--}}
{{--//                $('#countryName').selectpicker('refresh');--}}
{{--//                $('#countryName-error').hide();--}}

                {{--$('#country1').html(data.response_country);--}}
                {{--$('#country1').selectpicker('refresh');--}}

                {{--$('#country1-error').hide();--}}
            {{--}--}}
        {{--});--}}


        // $('#policyFrom').on('click', function(){
        //     $('#policyFrom').val(initialDate);
        // });
        // if($('#success').val() == 'success')
        // {
        //     $('#success_popup .cd-popup').addClass('is-visible');
        // }
        var data = '<?php echo @$preview_divs ?>';
        $(".ff_fileupload_uploads").append('<tbody id="data"></tbody>');
        $("#data").append(data);


        $(".ff_fileupload_uploads").on('click', '.btnDelete', function () {
            $(this).closest('tr').remove();
            // alert( $(this).parent().set('.saved_url').val() );
        });

        getState('country1','state1');
        materialKit.initFormExtendedDatetimepickers();





        /*
        * set values pre-selected for edit
        * */

        if($("#option_select2 :selected").val() == "existing_policy"){
            $("#existing_policy").show();
        }

        if($("#option_select3 :selected").val() == "WithinUAE"){
            $("#WithinUAE").show();
        }else if($("#option_select3 :selected").val() == "OutsideUAE"){
            $("#OutsideUAE").show();
        }

        if($("#option_select4 :selected").val() == "admin_employees"){
            $("#admin_employees").show();
        }else if($("#option_select4 :selected").val() == "non_admin_employees"){
            $("#non_admin_employees").show();
        }else if($("#option_select4 :selected").val() == "both_employees"){
            $("#both_employees").show();
        }

        if($("#option_select5 :selected").val() == "hired_workers"){
            $("#hired_workers").show();
        }

        if($("#option_select6 :selected").val() == "offshore_employees"){
            $("#offshore_employees").show();
        }

        $("#option_select2").change(function () {

            // DropDown Validation start
            var option_select2 = $("#option_select2 :selected").val();
            if(option_select2 == ''){
                $('#option_select2-error').show();
            }else{
                $('#option_select2-error').hide();
            }
            //end

            if ($(this).val() == "existing_policy") {
                $("#existing_policy").show();
            } else {
                $("#existing_policy").hide();
            }
        });
        $('#option_select3').change(function() {

            // DropDown Validation start
            var option_select3 = $("#option_select3 :selected").val();
            if(option_select3 == ''){
                $('#option_select3-error').show();
            }else{
                $('#option_select3-error').hide();
            }
            //end

            $('#WithinUAE').hide();
            $('#OutsideUAE').hide();
            $('#' + $(this).val()).show();
        });
        $('#option_select4').change(function() {

            // DropDown Validation start
            var option_select4 = $("#option_select4 :selected").val();
            if(option_select4 == ''){
                $('#option_select4-error').show();
            }else{
                $('#option_select4-error').hide();
            }
            // if(option_select4 == 'admin_employees')
            // {
            //     $('#description2').removeAttr('required','required');
            //     $('#minor_claim_amount2').removeAttr('required','required');
            //     $('#death_claim_amount2').removeAttr('required','required');
            //     $('#description1').attr('required','required');
            //     $('#minor_claim_amount1').attr('required','required');
            //     $('#death_claim_amount1').attr('required','required');
            // }
            // else if(option_select4 == 'non_admin_employees')
            // {
            //     $('#description1').removeAttr('required','required');
            //     $('#minor_claim_amount1').removeAttr('required','required');
            //     $('#death_claim_amount1').removeAttr('required','required');
            //     $('#description2').attr('required','required');
            //     $('#minor_claim_amount2').attr('required','required');
            //     $('#death_claim_amount2').attr('required','required');
            // }
            // else if(option_select4 == 'both_employees')
            // {
            //     $('#description1').attr('required','required');
            //     $('#minor_claim_amount1').attr('required','required');
            //     $('#death_claim_amount1').attr('required','required');
            //     $('#description2').attr('required','required');
            //     $('#minor_claim_amount2').attr('required','required');
            //     $('#death_claim_amount2').attr('required','required');
            // }
            // else
            // {
            //     $('#description2').removeAttr('required','required');
            //     $('#minor_claim_amount2').removeAttr('required','required');
            //     $('#death_claim_amount2').removeAttr('required','required');
            //     $('#description1').removeAttr('required','required');
            //     $('#minor_claim_amount1').removeAttr('required','required');
            //     $('#death_claim_amount1').removeAttr('required','required');
            // }
            //end

            $('#admin_employees').hide();
            $('#non_admin_employees').hide();
            $('#both_employees').hide();
            $('#' + $(this).val()).show();
        });
        $('#option_select5').change(function() {

            // DropDown Validation start
            var option_select5 = $("#option_select5 :selected").val();
            if(option_select5 == ''){
                $('#option_select5-error').show();
            }else{
                $('#option_select5-error').hide();
            }
            //end

            $('#hired_workers').hide();
            $('#' + $(this).val()).show();
        });
        $('#option_select6').change(function() {

            // DropDown Validation start
            var option_select6 = $("#option_select6 :selected").val();
            if(option_select6 == ''){
                $('#option_select6-error').show();
            }else{
                $('#option_select6-error').hide();
            }
            //end

            $('#offshore_employees').hide();
            $('#' + $(this).val()).show();
        });

        // $("input[type=radio][name='q22']:checked").val()

/*
* To set end date one year greater from start date (policy)
* */
        $("#policyFrom").blur( function () {
            var str = $("#policyFrom").val();
            if( /^\d{2}\/\d{2}\/\d{4}$/i.test( str ) ) {
                var parts = str.split("/");
                var day = parts[0] && parseInt( parts[0], 10 );
                var month = parts[1] && parseInt( parts[1], 10 );
                var year = parts[2] && parseInt( parts[2], 10 );
                var duration = 1;
                if( day <= 31 && day >= 1 && month <= 12 && month >= 1 ) {
                    var expiryDate = new Date( year, month - 1, day );
                    expiryDate.setFullYear( expiryDate.getFullYear() + duration );
                    var day = ( '0' + expiryDate.getDate() ).slice( -2 );
                    var month = ( '0' + ( expiryDate.getMonth() + 1 ) ).slice( -2 );
                    var year = expiryDate.getFullYear();
                    if (day>1)
                    {
                        day = day-1;
                        day = ('0' + day ).slice( -2 );
                    }
                    else
                    {
                        month = month-1;
                        if(month == 1 ||month == 3 ||month==5||month==7||month==8||month==10||month==12)
                        {
                            day = 31;
                        }
                        else
                        {
                            day = 30;
                        }
                        month = ( '0' + month ).slice( -2 );
                    }
                    $("#policyTo").val( day + "/" + month + "/" + year );
                    $("#policyTo-error").hide();

                }
            }
        });



    });

    $(document).ready(function () {
        var newDay,newMonth,newYear;
        var currentDate = new Date();
        var day = parseInt(currentDate.getDate());
        var month = parseInt(currentDate.getMonth() +1);
        var year = parseInt(currentDate.getFullYear());
        if(day == 31)
        {
            newDay = 30;
        }
        else
        {
            newDay = day;
        }
        if(month!=12 && month!=1)
        {
            newMonth = month + 1;
            newYear = year - 1;

        }
        if(month == 12)
        {
            newMonth = 1;
            newYear = year;
        }
        if(month == 1)
        {
            if(day==29 || day==30 || day==31)
            {
                newMonth = month+1;
                newYear = year-1;
            }
            else
            {
                newMonth = month + 1;
                newYear = year - 1;
            }

        }
        if(newDay<10)
            newDay = '0'+newDay;
        if(newMonth<10)
            newMonth = '0'+newMonth;
        initialDate = String(newDay+'/'+newMonth+'/'+newYear);
        $('#policyFrom').datetimepicker();
        $('#policyFrom').on('dp.show', function(e) {
            $(this).data('DateTimePicker').date(initialDate);
        });
        $('#btn-send').on('click', function () {
            $("#send_btn").attr( "disabled", false );
            $('#questionnaire_popup .cd-popup').addClass('is-visible');
            var id = $('#pipeline_id').val();
            $.ajax({
                method: 'get',
                url: '{{url('email-file')}}',
                data: {'id':id},
                success: function (result) {
                    if (result!= 'failed') {
                        $('#attach_div').html(result);
                    }
                    else
                    {
                        $('#attach_div').html('Files loading failed');
                    }
                }
            });

        });

        $('#listOfEmployees').change(function () {
            var fullPath = $('#listOfEmployees').val();
            if(fullPath=='')
            {
                $('#listOfEmployees-error').show();
            }
            else{
                $('#listOfEmployees-error').hide();
            }
            var startIndex = (fullPath.indexOf('\\') >= 0 ? fullPath.lastIndexOf('\\') : fullPath.lastIndexOf('/'));
            var filename = fullPath.substring(startIndex);
            if (filename.indexOf('\\') === 0 || filename.indexOf('/') === 0) {
                filename = filename.substring(1);
            }
//            console.log(filename);
            $('.remove_file_upload').show();
            $('#listEmployees').text(filename);
        });
        $('#taxRegistrationDocument').change(function () {
            var fullPath = $('#taxRegistrationDocument').val();
            if(fullPath=='')
            {
                $('#taxRegistrationDocument-error').show();
            }
            else{
                $('#taxRegistrationDocument-error').hide();
            }
            var startIndex = (fullPath.indexOf('\\') >= 0 ? fullPath.lastIndexOf('\\') : fullPath.lastIndexOf('/'));
            var filename = fullPath.substring(startIndex);
            if (filename.indexOf('\\') === 0 || filename.indexOf('/') === 0) {
                filename = filename.substring(1);
            }
//            console.log(filename);
            $('.remove_file_upload').show();
            $('#taxRegistration').text(filename);
        });
        $('#tradeLicense').change(function () {
            var fullPath = $('#tradeLicense').val();
            if(fullPath=='')
            {
                $('#tradeLicense-error').show();
            }
            else{
                $('#tradeLicense-error').hide();
            }
            var startIndex = (fullPath.indexOf('\\') >= 0 ? fullPath.lastIndexOf('\\') : fullPath.lastIndexOf('/'));
            var filename = fullPath.substring(startIndex);
            if (filename.indexOf('\\') === 0 || filename.indexOf('/') === 0) {
                filename = filename.substring(1);
            }
//            console.log(filename);
            $('.remove_file_upload').show();
            $('#tradeLicense_id').text(filename);
        });
        $('#policyCopy').change(function () {
            var fullPath = $('#policyCopy').val();
            if(fullPath=='')
            {
                $('#policyCopy-error').show();
            }
            else{
                $('#policyCopy-error').hide();
            }
            var startIndex = (fullPath.indexOf('\\') >= 0 ? fullPath.lastIndexOf('\\') : fullPath.lastIndexOf('/'));
            var filename = fullPath.substring(startIndex);
            if (filename.indexOf('\\') === 0 || filename.indexOf('/') === 0) {
                filename = filename.substring(1);
            }
//            console.log(filename);
            $('.remove_file_upload').show();
            $('#Copypolicy ').text(filename);
        });
    });




</script>

<script>
    //function fr getting statewice city details//
    function getState(country_div_id,state_div_id, state) {

        // validation start
        var country = $("#country1 :selected").val();
        if(country == ''){
            $('#country1-error').show();
        }else{
            $('#country1-error').hide();
        }
        //end
        var country_id = $('#'+country_div_id).val();
        $.ajax({
            type: "POST",
            url: "{{url('get-states')}}",
            data:{country_name : country_id,pipeline_id : '<?php echo $eQuestionnaireid;?>' , _token : '{{csrf_token()}}'},
            success: function(data){
                $('#state1').selectpicker('destroy');
                $('#'+state_div_id).html(data);
                $('#state1').selectpicker('setStyle');
            }
        });
    }
    //end


    /*
* Custom dropDown validation*/

    function dropDownValidation(){

        var state = $("#state :selected").val();
        if(state == ''){
            $('#state-error').show();
        }else{
            $('#state-error').hide();
        }

        var businessType = $("#businessType :selected").val();
        if(businessType == ''){
            $('#businessType-error').show();
        }else{
            $('#businessType-error').hide();
        }
        var currentInsurer = $('#currentInsurer').val();
        if(currentInsurer == '')
        {
            $('#currentInsurer-error').show();
        }
        else
        {
            $('#currentInsurer-error').hide();
        }

    }


    function loadFileTaxRegistation() {
        $('#saved_file_tax_registation').hide();
    }
    function loadFileTradeLicense() {
        $('#saved_file_trade_license').hide();
    }
    function loadFilelistOfEmployees() {
        $('#saved_file_employee_list').hide();
    }
    function loadFilepolicyCopy() {
        $('#saved_file_policy_file').hide();
    }
    function sendQuestion() {
        var form_data = new FormData($("#quest_send_form")[0]);
        var id = $('#pipeline_id').val();
        form_data.append('id',id);
        form_data.append('_token', '{{csrf_token()}}');
        $('#preLoader').show();
        $("#send_btn").attr( "disabled", true );
        // $("#button_submit").attr( "disabled", "disabled" );
        $.ajax({
            method: 'post',
            url: '{{url('employer/send-questionnaire')}}',
            data: form_data,
            cache : false,
            contentType: false,
            processData: false,
            success: function (result) {
                if (result!= 'failed') {
                    $('#questionnaire_popup .cd-popup').removeClass('is-visible');
                    $('#preLoader').hide();
                    $('#success_message').html(result);
                    $('#success_popup .cd-popup').addClass('is-visible');
                    $("#send_btn").attr( "disabled", false );
                }
                else
                {
                    $("#send_btn").attr( "disabled", false );
                    $('#questionnaire_popup .cd-popup').removeClass('is-visible');
                    $('#preLoader').hide();
                    $('#success_message').html('E-questionnaire already filled.');
                    $('#success_popup .cd-popup').addClass('is-visible');
                }
            }
        });
    }
    function placeValidation(obj)
    {
        if(obj.value != "")
        {
            $('#emirateName-error').hide();
            $('#countryName-error').hide();
        }
    }
    function saveQuestionnaire()
    {
        var form_data = new FormData($("#e_quest_form")[0]);
        form_data.append('output_url',output_url);
        form_data.append('output_file',output_file);
        form_data.append('is_save','true');
        form_data.append('_token', '{{csrf_token()}}');
        $('#preLoader').show();
        $.ajax({
            method: 'post',
            url: '{{url('employer/equestionnaire-save')}}',
            data: form_data,
            cache : false,
            contentType: false,
            processData: false,
            success: function (result) {
                $('.quest_file_upload').find('.ff_fileupload_remove_file').show();
                output_url = [];
                output_file = [];
                $('#btn-send').show();
                    $('#preLoader').hide();
                    if(result == 'success')
                    {
                        $( "#button_submit" ).removeAttr('disabled');
                        $( "#btn-send" ).removeAttr('disabled');
                        $( "#qs_save" ).removeAttr('disabled');
                        $('#success_message').html('E-Questionnaire is saved as draft.');
                        $('#success_popup .cd-popup').addClass('is-visible');
                    }
                    else
                    {
                        $( "#button_submit" ).removeAttr('disabled');
                        $( "#btn-send" ).removeAttr('disabled');
                        $( "#qs_save" ).removeAttr('disabled');
                        $('#success_message').html('E-Questionnaire saving failed.');
                        $('#success_popup .cd-popup').addClass('is-visible');
                    }
                }
        });
    }
</script>
@endpush


