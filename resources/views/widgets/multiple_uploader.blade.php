  <div class="row">
      <div class="container-fluid file_upload_demo" >
          <div class="table-uploadwrapper">
              <div class="uploadtable-title">
                <div class="row">
                  <div class="col-sm-12">
                    <label class="titles">
                      {{-- <b>Please Upload any other relevant documents</b> --}}
                       {{@$config['label']}} @if((!isset($config['notRequired']) && @$config['notRequired']!=true)) <span>*</span> @endif
                        @if (isset($config['templateUrl']))
                          <a style="margin-left:10px" target="_blank" href="{{@$config['templateUrl']}}">
                              <i title="Download Template" class="fa fa-download"></i>
                          </a>
                        @endif
                    </label>
                  </div>
                </div>
              </div>
            <table id="test-table" class="table">
              <tbody id="test-body">
                <tr id="row0" class="inputDnD">
                  <td style="border-top: .0625rem none #dee2e6;">                  
                    <div class="form-group ">
                        <div id="{{@$config['divId']}}" class="file-loading">
                          <input type="file" id="{{@$config['id']}}" name="documents[]" accept=".pdf, .jpg, .png, image/jpeg, image/png,.csv,.xlsx, .xls" multiple >
                          <input type="hidden"  name="{{@$config['fieldName']}}" value="{{@$configValue}}" class="multipleFileUploader">
                        </div>
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
    {{--  <div class="col-12 text-right">
        <button type="button" id="multiFileBtN" class="btn-sm btn-primary btnload">upload</button>
    </div>  --}}
            <div id="{{@$config['divId']}}ViewDiv" style="display:none;" class="container-fluid listofupload">
                <div class="row">
                    <div class="col-12">
                        <label class="titles"><b>List of Uploaded Files</b></label>
                    </div>
                </div>
                <div class="append_here" id="{{@$config['divId']}}_view">
                </div>
            </div>
          </div>
      </div>
  </div>
  <input type="hidden" id="complete_status" name="complete_status" value="">
  @push('widgetScripts')
    <script>
      $(document).ready(function(){          
        loadMultiFileS();
      });

            function loadMultiFileS() {
                var pipeline_id = $('#workTypeDataId').val();
                var fieldname="{{@$config['arrayIndex']}}";
                var flag;
                $.ajax({
                    method:"GET",
                    url:"{{url('get-uploaded-files')}}",
                    data:{'pipeline_id':pipeline_id, multi:2,'fieldname':fieldname},
                    type:"json",
                    success:function(data)
                    {
                        if(data.length<3)
                        {
                            $('#load').remove();
                            $('#{{@$config['divId']}}_view').append([
                                '<label id="no_file">No files are uploded</Label>'
                            ])
                        }
                        else
                        {
                            var newdata = JSON.parse(data);
                            $('#load').remove();
                            $('#{{@$config['divId']}}_view').html('');
                            $.each(newdata, function( index, value ) {
                                var extension = value.url.substr( (value.url.lastIndexOf('.') +1) );
                                if(extension=="jpg" || extension=="jpeg" || extension=="png")
                                {
                                    flag ='<img class="mr-2 up_img img-class" src="'+value.url+'">';
                                }
                                else
                                {
                                    flag ='<img class="mr-2 up_img file-class" src="{{URL::asset('img/main/test.png')}}">';
                                }
                                $('#{{@$config['divId']}}_view').append([
                                    '<div id="clone_this"  class="media  border p-3">'+
                                        flag+
                                        '<div class="media-body">'+

                                        '<label class="titles">'+value.filename+'</label>'+
                                        '<div class="viewbutton">'+
                                        '<button class="btn btn-primary btn-sm">' +
                                        '<a href="'+value.url+'" target="_blank" >View</a>'+
                                            '</button>'+
                                            '</div>'+
                                        '</div>'+
                                    '</div>'
                                ]);
                                $("#{{@$config['divId']}}ViewDiv").show();
                            });
                        }
                    }
                });
            }
            var file_upload_length=0;

         $( "#equestionare_documents" ).click(function() {
              var valid_form = [];
              var steps = JSON.parse($('#save_and_submit_later').val());
              steps.forEach(function(element){
                $("#"+element).addClass("show");
                 valid_form.push($("#basic_form"+element).valid());
                 if($("#basic_form"+element).valid() == false){
                  $("#"+element).addClass("show");
                 }else {
                    $("#"+element).removeClass("show");
                 }
              });
              
              console.log(jQuery.inArray(false, valid_form));
                if(jQuery.inArray(false, valid_form) == -1)
                {
                    $("#fullPageLoader").css('display', 'flex');
                    $('#complete_status').val(1);
                    $( "#equestionare_documents" ).prop('disabled','true');
    //                var queued_upload = $('.file_upload_demo ff_fileupload_queued').length;
                    var queued_upload = $('.file_upload_demo').find('.ff_fileupload_queued').length;
                    console.log(queued_upload);
                    $('.file_upload_demo').find('.ff_fileupload_remove_file').hide();
                    var arraylength=queued_upload;
                    console.log(arraylength);
                    if(arraylength!=0)
                    {
                        file_upload_length=arraylength;
                        $('#multipleFileUpload').next().find('.ff_fileupload_actions button.ff_fileupload_start_upload').click();return false;
                    }
                    else{
                        $('#basic_formdocuments').submit();
                    }5
                }
            });
          
        $( "#{{@$config['id']}}" ).on( "click", function() {
            $( ".ff_fileupload_wrap" ).trigger( "click" );
        });
 
        var output_url = [];
        var output_file = [];
        var output_url_file = [];
        var output_file_name = [];
        $(function() {
                $('#{{@$config['id']}}').FancyFileUpload({
                    params : {
                        action : 'fileuploader'
                    },
                    minFiles:1,
                    maxfilesize : 1000000,
                    url: '{{url('worktype-fileupload')}}',
                    method: 'post',
                    uploadcompleted: function (e, data) {
                        output_url_file.push(data.result.file_url);
                        output_file_name.push(data.result.file_name);
                        file_upload_length--;
                        if (file_upload_length == 0) {
                            console.log('success', output_url_file);
                            $('#{{@$config['divId']}} .multipleFileUploader').val("1").rules("remove", 'required');
                            documentFormSubmit(output_url_file, output_file_name);
                            multiDocumentFormSubmit(output_url_file, output_file_name, "{{@$config['arrayIndex']}}");
                        }
                    }
                });
        });



    </script>
  @endpush


