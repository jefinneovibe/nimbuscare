
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
                <form method="POST" enctype="multipart/form-data" name="workType_form" id="workType_form">
                    {{ csrf_field() }}
                    <div class="add_segment">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form_group custom_dp">
                                    <label class="form_label">Type the ID / name of the customer and retrieve the details <span>*</span></label>
                                    <select class="form-control" id="customer" name="customer"  onchange="getAgent();" onblur="dropDownValidation();">
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form_group">
                                    <label class="form_label">Work Type <span>*</span></label>
                                    <select class="selectpicker" data-hide-disabled="true" data-live-search="true" name="workType" id="workType" onchange="uploadShow(this);">
                                        <option selected value="" name="workType">Select Worktype</option>work_type
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
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form_label">Select Agent <span>*</span></label>
                                    <select class="selectpicker" data-hide-disabled="true" data-live-search="true" name="agent" id="agent"  onblur="dropDownValidation();">
                                        <option selected value="" name="agent">Select Agent</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form_group">
                                    <label class="form_label">Select Case Manager <span>*</span></label>
                                    <select class="selectpicker" data-hide-disabled="true" data-live-search="true" name="caseManager" id="caseManager" onblur="dropDownValidation();" onchange="getActiveCaseManagers('caseManager');" >
                                        <option selected value="" name="">Select Case Manager</option>
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
                        <div class="row" id="worksman_file" style="display: none">
                            <div class="col-md-3">
                                <div class="form_group">
                                    <label class="form_label">Tax registration document</label>
                                    <div class="custom_upload">
                                        <input type="file" name="taxRegistrationDocument" id="taxRegistrationDocument">
                                        <p id="taxRegistration">Drag your files or click here.</p>
                                    </div>
                                </div>

                            </div>
                            <div class="col-md-3">
                                <div class="form_group">
                                    <label class="form_label">Trade License</label>
                                    <div class="custom_upload">
                                        <input type="file" name="tradeLicense" id="tradeLicense">
                                        <p id="tradeLicense_id">Drag your files or click here.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form_group">
                                    <label class="form_label">List of employees</label>
                                    <div class="custom_upload">
                                        <input type="file" name="listOfEmployees" id="listOfEmployees">
                                        <p id="listEmployees">Drag your files or click here.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form_group">
                                    <label class="form_label">Copy of the policy if possible (upload) <span style="visibility: hidden">*</span></label>
                                    <div class="custom_upload">
                                        <input type="file" name="policyCopy" id="policyCopy">
                                        <p id="Copypolicy">Drag your files or click here.</p>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                    <div class="form-group"  {{--onblur="fileuploadValidation();"--}}>
                                        <label class="form_label">Upload File <span style="visibility: hidden">*</span></label>
                                        <div class="file-loading">
                                          <input id="documents" type="file" name="documents[]" accept=".jpg, .png, image/jpeg, image/png"  multiple >
                                        </div>
                                    </div>
                            </div>
                        </div>
                    </div>
                    <button class="btn btn-primary btn_action pull-right" name="button_submit" id="button_submit" type="button">Create Work Type</button>
                </form>
            </div>
            <a href = "{{ url ('basic-question')}}">Basic Questionnaire</a>

        </div>
    </div>

    <!-- Popup -->
    <div id="delete_file_popup">
        <form name="delete_file_popup_form" method="post" id="delete_file_popup_form">
            {{csrf_field()}}
            <div class="cd-popup">
                <div class="cd-popup-container">
                    <div class="modal_content">
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
                                        <p>Leaving the page will cancel the upload.<br>Are you sure you want to leave this page?</p>
                            </div>
                        </div>
                    </div>
                    <div class="modal_footer">
                        <button class="btn btn-primary btn-link btn_cancel">Cancel</button>
                        <button class="btn btn-primary btn_action" id="delete">Ok</button>
                    </div>
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
            </div>
        </div>
    </div>

    <div id="leave_popup">
        <div class="cd-popup">
            <div class="cd-popup-container">
                <div class="modal_content">
                    <div class="clearfix"></div>
                    <div class="content_spacing">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-12">
                                        <h3 style="font-size: 16px;margin: 10px 0;font-weight:  400;line-height: 23px;">This person is on leave till <span style="color: #0d6dea;" id="till_date"></span>.<br>Do you still want to assign it to the same person?</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal_footer">
                    <button class="btn btn-primary btn-link" id="cancel_button">No</button>
                    <button class="btn btn-primary btn_action" id="yes_button">Yes</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
<script src="{{URL::asset('js/main/jquery.validate.js')}}"></script>
<script src="{{URL::asset('js/main/additional-methods.min.js')}}"></script>

<script src="{{URL::asset('js/main/bootstrap-select.js')}}"></script>

<!-- Fancy FileUpload -->
<script src="{{URL::asset('js/file-uploader/jquery.ui.widget.js')}}"></script>
<script src="{{URL::asset('js/file-uploader/jquery.fileupload.js')}}"></script>
<script src="{{URL::asset('js/file-uploader/jquery.iframe-transport.js')}}"></script>
<script src="{{URL::asset('js/file-uploader/jquery.fancy-fileupload.js')}}"></script>
<script>

    $('#customer').select2({
        ajax: {
            url: '{{URL::to('get-customers')}}',
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    q: params.term, // search term
                    page: params.page
                };
            },
            processResults: function (data, params) {
                params.page = params.page || 1;
                return {
                    results: data.items,
                    pagination: {
                        more: (params.page * 10) < data.total_count
                    }
                };
            },
            cache: true
        },
            placeholder: "Select customer name/code",
            escapeMarkup: function (markup) { return markup; }, // let our custom formatter work
        templateResult: formatRepo,
        templateSelection: formatRepoSelection
    });

    function formatRepo (repo) {
        if (repo.loading) {
            return repo.text;
        }
        if(repo.customerCode!='')
        {
            var markup = repo.fullName+' ('+repo.customerCode+')';
        }
        else{
            var markup = repo.fullName;
        }
        return markup;
    }
    function formatRepoSelection (repo) {
        if(repo.fullName && repo.customerCode)
        {
            return repo.fullName +' ('+repo.customerCode +')';

        }else{
            return repo.text;

        }
    }
    var output_file_name = [];
    var output_url_file = [];
    $( "#yes_button" ).click(function() {
        $("#leave_popup .cd-popup").removeClass('is-visible');
    });
    $( "#cancel_button" ).click(function() {
        $("#leave_popup .cd-popup").removeClass('is-visible');
        $("#caseManager").val('default');
        $("#caseManager").selectpicker("refresh");

    });
    var file_length=0;
    $( "#button_submit" ).click(function() {
      var valid=  $("#workType_form").valid();
      if(valid==true)
      {
          $( "#button_submit" ).prop('disabled','true');
          var queued = $('.ff_fileupload_queued').length;
          $('.ff_fileupload_remove_file').hide();

          var arraylen=queued;
          if(arraylen!=0)
          {
              file_length=arraylen;
              $('#documents').next().find('.ff_fileupload_actions button.ff_fileupload_start_upload').click();return false;
          }
          else{
              $('#workType_form').submit();
          }
      }
    });
    $(function () {
        $(window).load(function() {
            window.onbeforeunload = null;
            $('#preLoader').fadeOut('slow');
            // localStorage.clear();
        });

    });
    var output_url = [];
    var output_file = [];
    $(function() {
            $('#documents').FancyFileUpload({
                params : {
                    action : 'fileuploader'
                },
                maxfilesize : 1000000,
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
    });

        //Create work type form validation
        $('#workType_form').validate({
            errorPlacement: function(error, element){
                if(element.attr("name") == "customer"){
                    error.insertAfter(element.parent());
                }
                else {
                    error.insertAfter(element);
                }
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
                agent:{
                    required:true
                },
                taxRegistrationDocument:{
                   accept:"image/jpg,image/jpeg,image/png,application/pdf,application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"
                },
                tradeLicense:{
                   accept:"image/jpg,image/jpeg,image/png,application/pdf,application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"
                },
                listOfEmployees:{
                   accept:"image/jpg,image/jpeg,image/png,application/pdf,application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"
                },
                policyCopy:{
                   accept:"image/jpg,image/jpeg,image/png,application/pdf,application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"
                },
                "file_upload_text[]": "required"
//                'documents[]': {
//                    required: function () {
//                        if($('.ff_fileupload_remove_file').length>0)
//                        return false;
//                        else
//                         return true;
//
//                    }
//                }
            },
            messages:{
                customer:"Please select  customer.",
                workType:"Please select a work type.",
                caseManager:"Please select case manager.",
                agent:"Please select an agent",
                taxRegistrationDocument:"Please upload valid file(.png,.jpeg,.jpg,.pdf,.xls)",
                tradeLicense:"Please upload valid file(.png,.jpeg,.jpg,.pdf,.xls)",
                listOfEmployees:"Please upload valid file(.png,.jpeg,.jpg,.pdf,.xls)",
                policyCopy:"Please upload valid file(.png,.jpeg,.jpg,.pdf,.xls)",
//                'documents[]':{
//                    required:"Please upload file."
//                },
                "file_upload_text[]": "Please enter file name"
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
        var agent = $('#agent').val();
        if(agent == '')
            $('#agent-error').show();
        else
            $('#agent-error').hide();
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
    }
    function getAgent()
    {
        var customer = $('#customer').val();
        $.ajax({
            type:"GET",
            url:"{{url('get-agent')}}",
            data:{'customer_id':customer},
            success:function(data){
                $('#agent').selectpicker('destroy');
                $('#agent').html(data);
                $('#agent').selectpicker('setStyle');
                $('#agent-error').hide();
                $('#customer-error').hide();
            }
        });
    }
    function getActiveCaseManagers(caseManager)
    {
        $('#button_submit').prop('disabled','true');
        var caseManager = $('#'+caseManager).val();

//            var caseManager = $("#caseManager :selected").val();
            if(caseManager == ''){
                $('#caseManager-error').show();
            }else{
                $('#caseManager-error').hide();
            }

        $.ajax({
            type:"post",
            url:"{{url('get-active-caseManager')}}",
            data:{'caseManager':caseManager,_token : '{{csrf_token()}}'},
            success:function(result) {
                if (result.status == 'leave') {
                    $("#leave_popup .cd-popup").toggleClass('is-visible');
                    $('#till_date').html(result.leave_date);
                }
                $('#button_submit').removeAttr("disabled");
            }
        });
    }

    $(document).ready(function(){
        $('#listOfEmployees').change(function () {


//
//                if(this.files[0].size > 1000000) {
//                    alert("Please upload file less than 1MB. Thanks!!");
//                }


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
            // if(fullPath=='')
            // {
            //     $('#policyCopy-error').show();
            // }
            // else{
            //     $('#policyCopy-error').hide();
            //
            // }
            var startIndex = (fullPath.indexOf('\\') >= 0 ? fullPath.lastIndexOf('\\') : fullPath.lastIndexOf('/'));
            var filename = fullPath.substring(startIndex);
            if (filename.indexOf('\\') === 0 || filename.indexOf('/') === 0) {
                filename = filename.substring(1);
            }
            $('.remove_file_upload').show();
            $('#Copypolicy ').text(filename);
        });
    });
    function uploadShow(obj) {
        var id  =obj.value;
        if(id == '5b34b18d3c63021e3c9698dc')
        {
            $('#worksman_file').show();
        }
        else
        {
            $('#worksman_file').hide();
        }
        dropDownValidation();
    }
</script>
<style>
#customer-error{
    margin-top: -18px;
    display: block;
}
</style>
@endpush


