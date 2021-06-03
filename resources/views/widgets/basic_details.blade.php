@if(!empty($config['rows']))
<form method="post" id="basic_form{{@$step}}">
    <input type="hidden" value="{{@$filler_type}}" id="filler_type" name="filler_type">
    <input type="hidden" id="workTypeId" name="workTypeId" value="{{@$workTypeId}}">
    <input type="hidden" id="stage" name="stage" value="{{@$stage}}">
    <input type="hidden" id="step" name="step" value="{{@$step}}">
    <input type="hidden" id="workTypeDataId" name="workTypeDataId" value="{{@$workTypeDataId}}">
    <input type="hidden" name="CFValueKey" value="{{@$CFValueKey}}">
    <input type="hidden" name="CFArrayKey" value="{{@$CFArrayKey}}">
    <input type="hidden" name="findFieldTotal" value="{{@$findFieldTotal}}">
    <div class="add_segment">
        @foreach(@$config['rows'] as $key => $row)
        <div class="row {{@$row['config']['class']}}">
            @foreach($row['fields'] as $field)
                {{-- @if (isset($values[$field['config']['fieldName']]) && @$values[$field['config']['fieldName']] != '')
                $basicDetailsValue = $values[$field['config']['fieldName']]; ?>
                @elseif (isset($field['config']['valueKey']) && @$field['config']['valueKey'] != '')
                    @if (isset($values[$field['config']['valueKey']]) && @$values[$field['config']['valueKey']] != '')
                    $basicDetailsValue = $values[$field['config']['valueKey']]; ?>
                    @endif
                @endif --}}
                @widget($field['widgetType'], ['data' => $field['config'],'formValues' =>@$formValues, 'workTypeId'=>@$workTypeId,'step'=>@$step ,'value' => @$values[$field['config']['fieldName']]?:@$values[$field['config']['valueKey']], 'workTypeDataId'=>@$workTypeDataId])
            @endforeach
        </div>
        @endforeach

    </div>
    <div class="row justify-content-end commonbutton">
        @if (isset($cancelButton) && $cancelButton == 1)
            <button type="button" class="btn btn-link  ml-auto closebutton" data-dismiss="modal">CANCEL</button>
            <button @if(@$step != 'documents')type="submit"@else type="button" @endif id="equestionare_{{@$step}}" class="btn btn-primary btnload" >Save</button>
        @else
            <button
                @if(@$step != 'documents')
                    type="submit"
                @else
                    type="button"
                @endif
                id="equestionare_{{@$step}}" class="btn btn-primary btnload" >
                @if(@$step != 'documents')
                    SAVE AND PROCEED
                @else
                    SAVE AND SUBMIT
                @endif
            </button>
        @endif
    </div>
</form>

   <style>
       .error {
        color:red;
        font-weight:600;
        font-size: 12px;
       }
   </style>


    @push('widgetScripts')

    <script>
    var draft = 0;
    $(document).ready(function () {
        // "fileSize" : "2097152"
        $.validator.addMethod("fileSize", function(value, element, param) {
            return  this.optional(element) || (element.files[0].size <= param);
        }, "Please upload a file less than 2MB");
        $.validator.addMethod("alphaNumSpace", function(value, element) {
            return this.optional(element) || /^[a-zA-Z\s]+$/i.test(value);
        }, "Only alphabetical characters");
        jQuery.validator.addMethod("alphanumeric", function(value, element) {
            return this.optional(element) || /^[\w.]+$/i.test(value);
        },
        "Letters, numbers, and underscores only please");

    //Create work type form validation
    $('#basic_form'+'{{@$step}}').validate({
            ignore: function (index, el) {
                        var $el = $(el);

                        if ($el.hasClass('multipleFileUploader') && ! $el.parentsUntil().parentsUntil().parentsUntil().parentsUntil().parentsUntil().hasClass("hided")) {
                            return false;
                        }

                        // Default behavior".ignore, :hidden:not(.multipleFileUploader)"
                        return $el.is(':hidden') || $el.is('.ignore') ;
                    },
            errorPlacement: function(error, element) {
                if (element.attr("name") == "customer") {
                    error.insertAfter(element.parent());
                }
                else if (element.attr('type')=='radio') {
                    error.insertAfter(element.parent().parent());
                }
                else if (element.attr('data-field-label') == 'prePostLabel') {
                    error.insertAfter(element.parent().parent());
                }
                else if (element.hasClass('datetimepicker')) {
                    error.insertAfter(element.parent());
                }
                else if (element.parent().hasClass('input-group')) {
                    error.insertAfter(element.parent());
                }
                else if(element.after().has(":hidden")) {
                    error.insertAfter(element);
                }
                else {
                    error.insertAfter(element.parent());
                }
            },
            rules:{},
            messages:{},
            submitHandler: function (form,event) {
                $("#equestionare_{{@$step}}").attr( "disabled", "disabled" );
                if ($("#equestionare_{{@$step}}").is((":disabled"))) {
                    console.log('submitting...');
                    var proceedToNextStage = '{{@$proceedToNextStage}}';
                    console.log(proceedToNextStage);
                    var form_data = new FormData($('#basic_form'+'{{@$step}}')[0]);
                    form_data.append('_token', '{{csrf_token()}}');
                    $('#preLoader').show();
                    var submitUrl = '{{url('save-equestionnaire')}}';
                    @if(@$step == 'locationDetails')
                        var submitUrl = '{{url('save-equestionnaire-multiple-details')}}';
                    @endif
                    $.ajax({
                        method: 'post',
                        url: submitUrl,
                        data: form_data,
                        cache : false,
                        contentType: false,
                        processData: false,
                        success: function (result) {
                            if (result== 'success') {
                                var workTypeDataId = $("#workTypeDataId").val();
                                console.log(proceedToNextStage);
                                if(proceedToNextStage == 1) {
                                    if($('#email_equestionare').val()){
                                        location.href = '{{url('customer-notification-equestionnare')}}'+'/'+workTypeDataId;
                                    } else {
                                        location.href = '{{url('eslip')}}'+'/'+workTypeDataId;
                                    }

                                } else {

                                    var cancelButton = '{{@$cancelButton}}';
                                    if (cancelButton == 1) {
                                        $("#multiForm_popup").modal('hide');
                                        if($('#email_equestionare').val()){
                                            var currentURL=window.location.href.split('?')[0];
                                            window.location.href = currentURL+"?"+1;
                                        } else {
                                            window.location.href = '{{url('equestionnaire')}}'+'/'+workTypeDataId+"?"+cancelButton;
                                        }
                                    } else {
                                        if($('#email_equestionare').val()){
                                            var currentURLSplit=window.location.href.split(/[?#]+/)[0];
                                            window.location.href =currentURLSplit;
                                        } else {
                                            window.location.href = '{{url('equestionnaire')}}'+'/'+workTypeDataId
                                        }
                                    }
                                }
                            }
                        }
                    });
                }

            }
        });

        });

        function multiDocumentFormSubmit(output_url_file, output_file_name,arrayIndex, formBtnId) {
            var workTypeDataId = $("#workTypeDataId").val();
            console.log(workTypeDataId);
            var form_data = new FormData();
            form_data.append('_token', '{{csrf_token()}}');
            form_data.append('output_url',output_url_file);
            form_data.append('output_file',output_file_name);
            form_data.append('arrayIndex',arrayIndex);
            form_data.append('workTypeDataId',workTypeDataId);
            $.ajax({
                method: 'post',
                async:false,
                url: '{{url('save-multi-documents')}}',
                data: form_data,
                cache : false,
                contentType: false,
                processData: false ,
                success: function (result) {
                location.reload();
                }
            });
        }

        function documentFormSubmit(output_url_file, output_file_name){
            console.log('submitting...');
            var proceedToNextStage = '{{@$proceedToNextStage}}';
            console.log(proceedToNextStage);
            var form_data = new FormData($('#basic_form'+'{{@$step}}')[0]);
            form_data.append('_token', '{{csrf_token()}}');
            form_data.append('output_url',output_url_file);
            form_data.append('output_file',output_file_name);
            $("#basicForm_submit").attr( "disabled", "disabled" );
            $('#preLoader').show();
            $.ajax({
                method: 'post',
                url: '{{url('save-equestionnaire')}}',
                data: form_data,
                cache : false,
                contentType: false,
                processData: false,
                success: function (result) {
                    if (result== 'success') {
                        var workTypeDataId = $("#workTypeDataId").val();

                        if(proceedToNextStage == 1 && draft != 1) {
                            if($('#email_equestionare').val()){
                                location.href = '{{url('customer-notification-equestionnare')}}'+'/'+workTypeDataId;
                            } else {
                                location.href = '{{url('eslip')}}'+'/'+workTypeDataId;
                            }

                        } else {
                            location.reload();
                        }
                    }
                }
            });
        }


        toalStepCount = 0;
        processStepCount = 0;
         function saveAndSubmitLater(steps){

            console.log('save and submit later');
            var steps = JSON.parse(steps);
            toalStepCount = steps.length;
            steps.forEach(async function(element){
                if(element == 'documents'){
                    var file_upload_length1=0;
                    $( "#equestionare_documents" ).prop('disabled','true');
        //                var queued_upload = $('.file_upload_demo ff_fileupload_queued').length;
                        var queued_upload = $('.file_upload_demo').find('.ff_fileupload_queued').length;
                        console.log(queued_upload);
                        $('.file_upload_demo').find('.ff_fileupload_remove_file').hide();
                        var arraylength=queued_upload;
                        console.log(arraylength);
                        if(arraylength!=0)
                        {
                            draft = 1;
                            file_upload_length=arraylength;
                            $('#multipleFileUpload').next().find('.ff_fileupload_actions button.ff_fileupload_start_upload').click();return false;
                        }
                        else{
                            await afterDocumentsCheck(element);
                        }
                } else {
                    await afterDocumentsCheck(element);
                }

            });
            if(processStepCount == toalStepCount) {
                setTimeout(function(){
                    location.reload();
                }, 400);
            }

        }

         function afterDocumentsCheck(step) {
            processStepCount = processStepCount+1;
                var form_data = new FormData($('#basic_form'+step)[0]);
                form_data.append('_token', '{{csrf_token()}}');
                form_data.append('type', 'draft');
                $.ajax({
                        method: 'post',
                        async:false,
                        url: '{{url('save-equestionnaire')}}',
                        data: form_data,
                        cache : false,
                        contentType: false,
                        processData: false,
                        success: function (result) {
                            if (result== 'success') {
                                var workTypeDataId = $("#workTypeDataId").val();
                                if(step == 'documents'){
                                    //location.reload();
                                }
                            }
                        }
                    });
        }








$(window).ready(function(){
    @if(!empty($config['validations']))
    @foreach($config['validations'] as $field)
    @if(!empty($field['validation']))
    var fieldName = '{{@$field['field']}}';
    @foreach($field['validation'] as $validator => $value)
    var val = '{{$value}}';
    var validationValue = '';
    if(val.length < 3 && parseInt(val, 10) !='NaN'){
        val = parseInt(val, 10);
    }
    $("#"+fieldName).rules("add", {
        {{$validator}} : val
    });
    @endforeach
    @endif
    @if(!empty($field['messages']))
    @foreach($field['messages'] as $validator => $message)
    $("#"+fieldName).rules("add", {
        messages: {
            {{$validator}} : '{{$message}}'
        }
    });
    @endforeach
    @endif
    @endforeach
    @endif
});

    </script>
    @endpush

    @endif
