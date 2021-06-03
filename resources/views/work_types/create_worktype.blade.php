
@extends('layouts.app')

@section('sidebar')
    @parent
@endsection

@section('content')
    <div class="section_details">
        <div class="card_header clearfix">
            <h3 class="title" style="margin-bottom: 8px;">Create Work Type</h3>
        </div>
        <div class="card_content">
            <div class="edit_sec clearfix">
                <form method="POST" action="{{{url('work-types')}}}" enctype="multipart/form-data" name="workType_form" id="workType_form">
                    {{ csrf_field() }}
                    <div class="add_segment">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form_group">
                                    <label class="form_label">Type the ID / name of the customer and retrieve the details <span>*</span></label>
                                    <select class="selectpicker" data-hide-disabled="true" data-live-search="true" name="customer" id="customer" onchange="dropDownValidation();">
                                        <option selected value="" name="customer">Select</option>
                                        @if(!empty($customers))
                                            @forelse($customers as $customer)
                                                <option {{ (old("customer") == $customer->_id? "selected":"") }} value="{{$customer->_id}}" data-display-text="">{{$customer->customerCode}} ({{$customer->fullName}})</option>
                                            @empty
                                                No customer types found.
                                            @endforelse
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form_group">
                                    <label class="form_label">Work Type <span>*</span></label>
                                    <select class="selectpicker" data-hide-disabled="true" data-live-search="true" name="workType" id="workType" onchange="dropDownValidation();">
                                        <option selected value="" name="workType">Select</option>work_type
                                        @if(!empty($work_type))
                                            @forelse($work_type as $type)
                                                <option {{ (old("workType") == $type->_id? "selected":"") }} value="{{$type->_id}}" data-display-text="">{{$type->name}}</option>
                                            @empty
                                                No work type found.
                                            @endforelse
                                        @endif

                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form_group">
                                    <label class="form_label">Select Case Manager <span>*</span></label>
                                    <select class="selectpicker" data-hide-disabled="true" data-live-search="true" name="caseManager" id="caseManager" onchange="dropDownValidation();">
                                        <option selected value="" name="caseManager">Select</option>
                                        @if(!empty($case_managers))
                                            @forelse($case_managers as $case)
                                                <option {{ (old("workType") == $case->_id? "selected":"") }} value="{{$case->_id}}" data-display-text="">{{$case->name}}</option>
                                            @empty
                                                No work type found.
                                            @endforelse
                                        @endif
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                {{-- <form enctype="multipart/form-data"> --}}
                                    <div class="form-group">
                                        <label class="form_label">Upload File <span>*</span></label>
                                        <div class="file-loading">
                                            {{--<input id="file-1" type="file" multiple class="file" data-overwrite-initial="false" data-min-file-count="2" name="file">--}}
                                            <input id="documents" type="file" name="documents[]" accept=".jpg, .png, image/jpeg, image/png"  multiple>
                                            {{--<label id="error_file" style="display: none">File name Required</label>--}}
                                        </div>
                                    </div>
                                {{-- </form> --}}
                            </div>
                        </div>
                        <!--<button type="button" class="btn btn-primary pull-left" onclick="$('#documents').next().find('.ff_fileupload_actions button.ff_fileupload_start_upload').click(); return false;">Uploads files</button>-->

                    </div>
                    {{--<button type="button" onclick="$('#documents').next().find('.ff_fileupload_actions button.ff_fileupload_start_upload').click(); return false;">Create Work Type</button>--}}

                    <button class="btn btn-primary btn_action pull-right" name="button_submit" id="button_submit" type="button">Create Work Type</button>
                    <button class="btn btn-primary btn_action pull-right" name="button_upload" id="button_upload"  style="display:none;background-color: #4cae4c" type="button">Uploading ..</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Popup -->
    <div id="delete_file_popup">
        <form name="delete_file_popup_form" method="post" id="delete_file_popup_form">
            {{csrf_field()}}
            {{--<input type="hidden" name="pipeline_id" value="{{@$worktype_id}}">--}}
            <div class="cd-popup">
                <div class="cd-popup-container">
                    <div class="modal_content">
                        {{--<h1>Insurance Companies List</h1>--}}

                        <div class="content_spacing">
                            <div class="row">
                                <div class="col-md-6" id="insurer_list">

                                </div>
                            </div>

                        </div>

                        <div class="modal_footer">
                            <button class="btn btn-primary btn-link btn_cancel">Cancel</button>
                            <button class="btn btn-primary btn_action" id="insurance_button" type="submit">Submit</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div><!--//END Popup -->

    <div id="upload_popup">
        <div class="cd-popup">
            <div class="cd-popup-container">
                <div class="modal_content">
                    <h1>File Upload</h1>
                    <div class="clearfix"></div>
                    <div class="content_spacing">
                        <div class="row">
                            <div class="col-md-12">
                                        <p>Upload or Remove the files from list before submitting.</p>
                            </div>
                        </div>
                    </div>
                </div>
                {{--<div class="modal_footer">--}}
                    {{--<button class="btn btn-primary btn-link btn_cancel">Ok</button>--}}
                {{--</div>--}}
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
                {{--<div class="modal_footer">--}}
                    {{--<button class="btn btn-primary btn-link btn_cancel">Ok</button>--}}
                {{--</div>--}}
            </div>
        </div>
    </div>

@endsection

@push('scripts')
<script src="{{URL::asset('js/main/jquery.validate.js')}}"></script>
<script src="{{URL::asset('js/main/bootstrap-select.js')}}"></script>

<!-- Fancy FileUpload -->
<script src="{{URL::asset('js/file-uploader/jquery.ui.widget.js')}}"></script>
<script src="{{URL::asset('js/file-uploader/jquery.fileupload.js')}}"></script>
<script src="{{URL::asset('js/file-uploader/jquery.iframe-transport.js')}}"></script>
<script src="{{URL::asset('js/file-uploader/jquery.fancy-fileupload.js')}}"></script>
<script>

var file_length=0;
    $( "#button_submit" ).click(function() {
        var queued = $('.ff_fileupload_remove_file').length;
        var arraylen=queued/2;
        fileupload(arraylen);
    });

    $(function () {
        $(window).load(function() {
            $('#preLoader').fadeOut('slow');
            // localStorage.clear();
        });
        fileupload(0);
    });

    var output_url = [];
    var output_file = [];

        function fileupload(arraylength) {
            file_length=arraylength;
          $('#documents').next().find('.ff_fileupload_actions button.ff_fileupload_start_upload').click();
            $('#documents').FancyFileUpload({
                params : {
                    action : 'fileuploader'
                },
                url: '{{url('worktype-fileupload')}}',
                method: 'post',
                uploadcompleted: function (e, data) {
                    output_url.push(data.result.file_url);
                    output_file.push(data.result.file_name);
                    file_length--;
                    if (file_length == 0) {
                        $('#workType_form').submit();
                    }
                }
            });
        }

        //Create work type form validation
        $('#workType_form').validate({
            errorPlacement: function(error, element){
                    error.insertAfter(element.parent());
            },
            ignore:[],
            rules:{
                customer:{
                    required:true
                },
                workType:{
                    required:true
                },
                caseManager:{
                    required:true
                },
                'documents[]': {
                    required: function () {
                        if($('.ff_fileupload_remove_file').length>0)
                        return false;
                        else
                         return true;

                    }
                }
            },
            messages:{
                customer:"Please select  customer.",
                workType:"Please select a work type.",
                caseManager:"Please select case manager.",
                'documents[]':{
                    required:"Please upload file."
                }
            },
            submitHandler: function (form,event) {

                    var form_data = new FormData($("#workType_form")[0]);
                    form_data.append('output_url',output_url);
                    form_data.append('output_file',output_file);
                    form_data.append('_token', '{{csrf_token()}}');
                    $("#button_submit").attr( "disabled", "disabled" );
                    $('#preLoader').show();
                    $.ajax({
                        method: 'post',
                        url: '{{url('work-types-save')}}',
                        data: form_data,
                        cache : false,
                        contentType: false,
                        processData: false,
                        success: function (result) {
                            if (result== 'success') {
                                window.location.href = '{{url('pipelines')}}';
                            }
                        }
                    });
            }
        });
    /*
   * Custom dropDown validation*/

    function dropDownValidation(){
        var customer = $("#customer :selected").val();
        if(customer == ''){
            $('#customer-error').show();
        }else{
            $('#customer-error').hide();
        }

        var workType = $("#workType :selected").val();
        if(workType == ''){
            $('#workType-error').show();
        }else{
            $('#workType-error').hide();
        }

        var caseManager = $("#caseManager :selected").val();
        if(caseManager == ''){
            $('#caseManager-error').show();
        }else{
            $('#caseManager-error').hide();
        }

    }


</script>
@endpush


