@if (!empty($config))
<div  id="{{@$config['divId']}}" class="col-12">
    <div class="col-3">
        <label class="titles">
            {{@$config['label']}} @if((!isset($config['notRequired']) && @$config['notRequired']!=true)) <span>*</span> @endif
        </label>
    @if (isset($config['templateUrl']))
        <a style="margin-left:10px" target="_blank" href="{{@$config['templateUrl']}}">
            <i title="Download Template" class="fa fa-download"></i>
        </a>
    @endif
</div>
    <div class="col-12 inputDnD">
        <div class="form-group">
            <div class="file_uploader">
                <input type="file" id="{{@$config['id']}}" name="documents[]"  class="form-control-file text-primary font-weight-bold"  accept="{{@$config['accept']}}" {{@$config['multiple']?"multiple":""}} data-title=" + Upload">
                <input type="hidden" name="{{@$config['fieldName']}}" value="{{@$configValue}}" class="multipleFileUploader">
            </div>
        </div>
    </div>
    <div class="col-12 text-right">
        <button type="button" id="multiFileBtn" class="btn-sm btn-primary btnload">upload</button>
    </div>
</div>
    @if (!empty($value))
        <div id="{{@$config['divId']}}ViewDiv" class="container-fluid listofupload">
            <div class="row">
                <div class="col-12">
                    <label class="titles"><b>List of Uploaded Files</b></label>
                </div>
            </div>
            <div class="row">
                @foreach ($value as $file)
                    @if (isset($file['url']) && $file['url'] != '' && $file['upload_type'] == @$config['valueKey'] )
                        <div class="col-3 flex_label">
                            <label class="titles" style="word-break: break-all;" for="filename">{{$file['file_name']}}</label>
                            <a target="_blank" class="btn file_uploadBtn btn-sm btn-primary" href="{{$file['url']}}">view</a>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    @endif

@endif

@push('widgetScripts')
<script>
    $(window).load(function(){
        $('#{{@$config['divId']}} .multipleFileUploader').rules("add", {
            required : true
        });
        $('#{{@$config['divId']}} .multipleFileUploader').rules("add", {
            messages: {
                required : 'Please enter this field.'
            }
        });
    });
        var multifile_upload_length=0;
    $(window).ready(function(){
        var formId = $("#{{@$config['divId']}}").closest('form').attr("id");
        var formBtnId = $("#{{@$config['divId']}}").closest('form').find(':submit').attr("id");
        $( "#multiFileBtn").click(function() {
          var queued = $('.ff_fileupload_queued').length;
          $('.ff_fileupload_remove_file').hide();

          var arraylen=queued;
          if(arraylen!=0)
          {
            multifile_upload_length=arraylen;
          $( "#"+formBtnId ).prop('disabled','true');
          $( "#multiFileBtn" ).prop('disabled','true');
              $('#{{@$config['id']}}').next().find('.ff_fileupload_actions button.ff_fileupload_start_upload').click();return false;
          }
          else{
              $('#'+formId).submit();
          }
    });
    });
    var output_url = [];
    var output_file = [];
    var output_url_file = [];
    var output_file_name = [];
        $( "#{{@$config['id']}}").on( "click", function() {
        $( ".ff_fileupload_wrap" ).trigger( "click" );
    });
    $("#{{@$config['id']}}").FancyFileUpload({
        params : {
            action : 'fileuploader'
        },
        maxfilesize : 1000000,
        url: '{{url('worktype-fileupload')}}',
        method: 'post',
        uploadcompleted: function (e, data) {
            output_url_file.push(data.result.file_url);
            output_file_name.push(data.result.file_name);
            multifile_upload_length--;
            if (multifile_upload_length == 0) {
                $('#{{@$config['divId']}} .multipleFileUploader').val("1").rules("remove", 'required');
                console.log('success', output_url_file);
                var formId = $("#{{@$config['divId']}}").closest('form').attr("id");
                var formBtnId = $("#{{@$config['divId']}}").closest('form').find(':submit').attr("id");
                var form_data = new FormData($('#'+formId)[0]);
                form_data.append('_token', '{{csrf_token()}}');
                form_data.append('type', 'draft');
                $.ajax({
                        method: 'post',
                        async:false,
                        url: '{{url('save-equestionnaire')}}',
                        data: form_data,
                        cache : false,
                        contentType: false,
                        processData: false
                    });
                multiDocumentFormSubmit(output_url_file, output_file_name, "{{@$config['arrayIndex']}}", formBtnId);
            }
        }
    });
    </script>
  @endpush
