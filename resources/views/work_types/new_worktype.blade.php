@extends('layouts.worktype_layout')



@section('content')

<div id="content">
    <!-- create worktype content-->
    <div class="mycontainer shadow">
        <div class="heading">
            <h6 class="title">Create Worktype</h6>
        </div>
        <div class="contentbody">
            <form method="POST" enctype="multipart/form-data" name="workType_form" id="workType_form">
                <div class="row">
                    <div class="col-md-5">
                        <div class="form-group">
                            <label><b class="titles">Type ID / Name of the customer and retrieve the details <span>*</span></b></label>
                        </div>
                    </div>
                    <div class="col-md-7">
                        <div class="form-group">
                        <select class="form-control " id="customer" name="customer"  onchange="getAgent();" onblur="dropDownValidation();">
                                    </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-5">
                        <div class="form-group">
                            <label><b class="titles">Work Type <span>*</span></b></label>
                        </div>
                    </div>
                    <div class="col-md-7">
                        <div class="form-group">
                            <select class="form-control selectpicker" data-hide-disabled="true" data-live-search="true" name="workType" id="workType" onchange="uploadShow(this);">
                            <option value="" name="workType">Select Worktype</option>work_type
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
                    <div class="col-md-5">
                        <div class="form-group">
                            <label><b class="titles">Select Agent <span>*</span></b></label>
                       </div>
                    </div>
                    <div class="col-md-7">
                        <div class="form-group">
                        <select class="form-control selectpicker" data-hide-disabled="true" data-live-search="true" name="agent" id="agent"  onblur="dropDownValidation();">
                            <option selected value="" name="agent">Select Agent</option>
                        </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-5">
                        <div class="form-group">
                            <label><b class="titles">Select Case Manager <span>*</span></b></label>

                        </div>
                    </div>
                    <div class="col-md-7">
                        <div class="form-group">
                            <select class="form-control selectpicker" data-hide-disabled="true" data-live-search="true" name="caseManager" id="caseManager" onblur="dropDownValidation();" onchange="getActiveCaseManagers('caseManager');" >
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
                <div class="row">
                    <div class="col-md-5">
                        <div class="form-group">
                            <label><b class="titles">Upload File </b></label>

                        </div>
                    </div>
                    <div class="col-md-7 inputDnD">
                        <div class="form-group">
                         <div class="file_uploader">
                            <input type="file" id="documents" name="documents[]" class="form-control-file d-block text-primary font-weight-bold"  accept=".pdf, .jpg, .png, image/jpeg, image/png" multiple  data-title=" + Upload">
                        </div>
                        </div>
                    </div>
                </div>


            </form>
            <div class="row justify-content-end commonbutton">
                <button class="btn btn-primary btnload" name="button_submit" id="button_submit" type="button">
                    <!-- <a href="{{url('e-questionnaire')}}" role="button" style="color:#ffffff;" target="_self">CREATE WORKTYPE</a> -->
                    <a role="button" style="color:#ffffff;" target="_self">CREATE WORKTYPE</a>
                </button>
            </div>
        </div><!-- content body  ends-->
    </div><!----mycontainer ends-->
</div><!--content ends-->





 <!--------modal----->
 <div class="modal fade" id="leave_popup" tabindex="-1" role="dialog" aria-labelledby="leave_popup" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-lg" role="document">
            <div class="modal-content  ">
                <div class="modal-header">
                    <h3 style="font-size: 16px;margin: 10px 0;font-weight:  400;line-height: 23px;">This person is on leave till <span style="color: #0d6dea;" id="till_date"></span>.<br>Do you still want to assign it to the same person?</h3>
                </div>
                <div class="commonbutton modal-footer">
                    <button type="button" class="btn btn-link  ml-auto closebutton" id="cancel_button" data-dismiss="modal">No</button>
                    <button type="button" class="btn btn-primary btnload" id="yes_button" data-dismiss="modal">Yes</button>
                </div>
            </div>
        </div>
    </div>
<!------modal end-->


@endsection

@push('widget-scripts')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
{{-- <script src="{{URL::asset('js/main/jquery.validate.js')}}"></script>
<script src="{{URL::asset('js/main/additional-methods.min.js')}}"></script> --}}

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
            placeholder: "Select Customer Name/Code",
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
        // $("#leave_popup .cd-popup").removeClass('is-visible');
    });
    $( "#cancel_button" ).click(function() {
        // $("#leave_popup .cd-popup").removeClass('is-visible');
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
        $(window).on('load', function() {
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
                    $("#leave_popup").modal();
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

    $(".ff_fileupload_wrap").hide();

    $( "#documents" ).on( "click", function() {
        $( ".ff_fileupload_wrap" ).trigger( "click" );
    });



</script>
<style>

.file_uploader{
    position: relative;
}
.ff_fileupload_wrap .ff_fileupload_dropzone{
    position: absolute;
    width: 100%;
    padding: 0;
    top: 0;
    left: 0;
    height: 43px !important;
    opacity: 0;
}
.ff_fileupload_wrap .ff_fileupload_dropzone:hover,
.ff_fileupload_wrap .ff_fileupload_dropzone:active,
.ff_fileupload_wrap .ff_fileupload_dropzone:focus{
    opacity: 0;
}
</style>
@endpush


