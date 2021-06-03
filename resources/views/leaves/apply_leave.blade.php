
@extends('layouts.app')

@section('sidebar')
    @parent
@endsection

@section('content')
    <div class="section_details">
        <div class="card_header clearfix">
            <h3 class="title" style="margin-bottom: 8px;">Add Leave</h3>
        </div>
        <div class="card_content">
            <div class="edit_sec clearfix">
                <form method="post" name="apply_leave_form" id="apply_leave_form">
                    {{ csrf_field() }}
                    <div class="add_segment">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form_group">
                                    <label class="form_label">Select Case Manager <span>*</span></label>
                                    <select class="selectpicker" data-hide-disabled="true" data-live-search="true" name="caseManager" id="caseManager" onchange="dropDownValidation();">
                                        <option selected value="" name="caseManager">Select Case Manager</option>
                                        @if(!empty($case_managers))
                                            @forelse($case_managers as $case)
                                                <option  value="{{$case->_id}}" data-display-text="">{{$case->name}}</option>
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
                                <label class="form_label bold">Leave Period <span>*</span></label>
                            </div>
                            <div class="col-md-6">
                                <div class="form_group">
                                    <input class="form_input datetimepicker" placeholder="From" name="leaveFrom" id="leaveFrom"  type="text">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form_group">
                                    <input class="form_input datetimepicker" placeholder="To" name="leaveTo" id="leaveTo" type="text">
                                </div>
                            </div>
                        </div>
                    </div>
                    <button class="btn btn-primary btn_action pull-right" name="button_submit" id="button_submit" type="submit">Save</button>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{URL::asset('js/main/jquery.validate.js')}}"></script>
    <!-- Date Picker -->
    <script src="{{URL::asset('js/main/bootstrap-datetimepicker.js')}}"></script>
    <script src="{{URL::asset('js/main/bootstrap-select.js')}}"></script>
    <script>
        $(function () {
            materialKit.initFormExtendedDatetimepickers();

            $(window).load(function() {
                window.onbeforeunload = null;
                $('#preLoader').fadeOut('slow');
                // localStorage.clear();
            });

        });
        var today = new Date();
        var dd = today.getDate();
        var mm = today.getMonth()+1; //January is 0!
        var yyyy = today.getFullYear();

        if(dd<10) {
            dd = '0'+dd
        }

        if(mm<10) {
            mm = '0'+mm
        }

        today = mm + '/' + dd + '/' + yyyy;

        jQuery.validator.addMethod("greaterThan",
            function(value, element, params) {
                var from = $(params).val().split("/");
                var fromDate = new Date(from[2], from[1] - 1, from[0]);
                var to = $('#leaveTo').val().split("/");
                var toDate = new Date(to[2], to[1] - 1, to[0]);
                if(toDate>=fromDate)
                {
                    return toDate>=fromDate;
                }
            },'Must be greater than policy from date.');
        jQuery.validator.addMethod("currentOrFuture",
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
            },'Must be greater than current date.');

        //Create work type form validation
        $('#apply_leave_form').validate({
            errorPlacement: function(error, element){
                error.insertAfter(element);
            },
            ignore:[],
            rules:{
                leaveFrom:{
                    required:true
                },
                leaveTo:{
                    greaterThan: "#leaveFrom",
                    currentOrFuture: "#leaveTo",
                    required:true
                },
                caseManager:{
                    required:true
                }
            },
            messages:{
                leaveFrom:"Please select  from date.",
                leaveTo:{
                    greaterThan:"Please select correct date.",
                    required:"Please select to date."
                },
                caseManager:"Please select case manager."
            },
            submitHandler: function (form,event) {
                var form_data = new FormData($("#apply_leave_form")[0]);
                form_data.append('_token', '{{csrf_token()}}');
                $("#button_submit").attr( "disabled", "disabled" );
                $('#preLoader').show();
                $.ajax({
                    method: 'post',
                    url: '{{url('leave/save-leave')}}',
                    data: form_data,
                    cache : false,
                    contentType: false,
                    processData: false,
                    success: function (result) {
                        if (result.success== true) {
                            window.location.href = '{{url('leave/leave-list')}}';
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

            var caseManager = $("#caseManager :selected").val();
            if(caseManager == ''){
                $('#caseManager-error').show();
            }else{
                $('#caseManager-error').hide();
            }
            if($('.ff_fileupload_remove_file').length>0)

                $('#documents-error').html('');
        }
        $('#documents').change(function(){
            //console.log("innnnnn");
            if($('.ff_fileupload_remove_file').length>0)

                $('#documents-error').html('');
        });
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
        $(document).ready(function(){
            $('#listOfEmployees').change(function () {
                var fullPath = $('#listOfEmployees').val();
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
@endpush


