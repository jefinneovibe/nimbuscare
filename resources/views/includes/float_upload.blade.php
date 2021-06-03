<!----------------------------------floating upload------------------------------------------->
<div class="floatingupload">
    <button class="uploadbutton" onclick="loadFiles()" data-toggle="collapse"> <i class="fa fa-cloud-upload" aria-hidden="true"></i></button>
</div>

<div class="right-sidebar right-bar-block rightside-animate-right " style="display:none;right:0;" id="rightMenu"><!--  w3-card -->
    <button onclick="closeRightMenu()" class="right-bar-item">Close <span class="close red">&times;</span></button><!--w3-button w3-large-->
    <form id="upload_file_form" name="upload_file_form" method="post">
        <div class="container-fluid file_upload_demo" >
            <br>
            <div class="row">
                <div class="col-12">
                    <label class="titles"><b>Upload Files</b></label>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div id="img_prview_area" style="display: none;">
                        <img id="image_preview"/>
                        <span id="file_preview"></span>
                    </div>
                    <div class="file_uploader">
                        <input type="file" id="documentfiles" name="documents[]" class="form-control-file text-primary font-weight-bold"  accept=".pdf, .jpg, .png, image/jpeg, image/png,.csv,.xlsx, .xls" multiple  >
                    </div>
                </div>
            </div>
                <br>
        </div>
    </form>
    <div class="commonbutton">
        <button type="button" id="button_submit_fileupload" class="btn btn-primary btnload">UPLOAD</button>
    </div>
    <div class="container-fluid listofupload">
        <div class="row">
            <div class="col-12">
                <label class="titles"><b>List of Uploaded Files</b></label>
            </div>
        </div>
        <div class="append_here" id="file_view">
        </div>
    </div>
</div>

    <!----------------------------------floating upload end------------------------------------------>

    @push('widgetScripts')


    <!-- Fancy FileUpload -->
    <script src="{{URL::asset('js/file-uploader/jquery.ui.widget.js')}}"></script>
    <script src="{{URL::asset('js/file-uploader/jquery.fileupload.js')}}"></script>
    <script src="{{URL::asset('js/file-uploader/jquery.iframe-transport.js')}}"></script>
    <script src="{{URL::asset('js/file-uploader/jquery.fancy-fileupload.js')}}"></script>

    <script>

        var file_upload_length=0;
            $( "#button_submit_fileupload" ).click(function() {
                var valid_form=  $("#upload_file_form").valid();
                console.log(valid_form);
                if(valid_form==true)
                {
                    $( "#button_submit_fileupload" ).prop('disabled','true');

    //                var queued_upload = $('.file_upload_demo ff_fileupload_queued').length;
                    var queued_upload = $('.file_upload_demo').find('.ff_fileupload_queued').length;
                    $('.file_upload_demo').find('.ff_fileupload_remove_file').hide();
                    var arraylength=queued_upload;
                    if(arraylength!=0)
                    {
                        file_upload_length=arraylength;
                        $('#documentfiles').next().find('.ff_fileupload_actions button.ff_fileupload_start_upload').click();return false;
                    }
                    else{
                        $('#upload_file_form').submit();
                    }
                }
            });
        $( "#documentfiles" ).on( "click", function() {
            $( ".ff_fileupload_wrap" ).trigger( "click" );
        });
        var output_url = [];
        var output_file = [];
        var output_url_file = [];
        var output_file_name = [];
        $(function() {
                $('#documentfiles').FancyFileUpload({
                    params : {
                        action : 'fileuploader'
                    },
                    maxfilesize : 1000000,
                    url: '{{url('worktype-fileupload')}}',
                    method: 'post',
                    uploadcompleted: function (e, data) {
                        output_url_file.push(data.result.file_url);
                        output_file_name.push(data.result.file_name);
                        file_upload_length--;
                        if (file_upload_length == 0) {
                            $('#upload_file_form').submit();
                        }
                    }
                });
        });

    //Create file upload form validation
    $('#upload_file_form').validate({
                errorPlacement: function(error, element){
                    error.insertAfter(element.parent());
                },
                ignore:[],
                rules:{
                    "file_upload_text[]": "required",
                    'documents[]': {
                        required: function () {
                            if($('.file_upload_demo').find('.ff_fileupload_remove_file').length>0)
                                return false;
                            else
                                return true;

                        }
                    }
                },
                messages:{
                    'documents[]':{
                        required:"Please upload file."
                    },
                    "file_upload_text[]": "Please enter file name"
                },
                submitHandler: function (form,event) {
                    var flag;
                    var form_data = new FormData($("#upload_file_form")[0]);
                    form_data.append('output_url',output_url_file);
                    form_data.append('output_file',output_file_name);
                    form_data.append('worktype_id', $('#workTypeDataId').val());
                    form_data.append('_token', '{{csrf_token()}}');
                    $("#button_submit_fileupload").attr( "disabled", "disabled" );
                    $.ajax({
                        method: 'post',
                        url: '{{url('all-documents-save')}}',
                        data: form_data,
                        cache : false,
                        contentType: false,
                        processData: false,
                        success: function (result) {
                            if (result.success== 'success') {
                                $('#no_file').remove();
                                $("#button_submit_fileupload").attr( "disabled", false );
                                $.each(output_url_file, function( index, value ) {
                                    var extension = value.substr( (value.lastIndexOf('.') +1) );
                                    if(extension=="jpg" || extension=="jpeg" || extension=="png")
                                    {
                                        flag ='<img class="mr-2 up_img img-class" src="'+value+'">';
                                    }
                                    else
                                    {
                                        flag ='<img class="mr-2 up_img file-class" src="{{URL::asset('img/main/test.png')}}">';
                                    }
                                    $('#file_view').append([
                                        '<div id="clone_this"  class="media  border p-3">'+
                                        flag+
                                        '<div class="media-body">'+
                                        '<label class="titles">'+output_file_name[index]+'</label>'+
                                        '<div class="viewbutton">'+
                                        '<button class="btn btn-primary btn-sm">' +
                                        '<a href="'+value+'" target="_blank">View</a>'+
                                            '</button>'+
                                            '</div>'+
                                        '</div>'+
                                    '</div>'
                                    ])
                                });
                                $('.file_upload_demo').find(".ff_fileupload_uploads").empty();
                                output_url_file = [];
                                output_file_name = [];
                            }
                        }
                    });
                }
            });
            // onclick=\"window.open(\''+value+'\', \n\'newwindow\', \n\'width=2000,height=1500\'); \nreturn false;\"
            function loadFiles() {
                document.getElementById("rightMenu").style.display = "block";
                var pipeline_id = $('#workTypeDataId').val();
                var flag;
                $.ajax({
                    method:"GET",
                    url:"{{url('get-uploaded-files')}}",
                    data:{'pipeline_id':pipeline_id},
                    type:"json",
                    success:function(data)
                    {
                        if(data.length<3)
                        {

                            $('#load').remove();
                            $('#file_view').append([
                                '<label id="no_file">No files are uploded</Label>'
                            ])
                        }
                        else
                        {
                             var newdata = JSON.parse(data);
                            $('#load').remove();
                            $('#file_view').html('');
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
                                $('#file_view').append([
                                    '<div id="clone_this"  class="media  border p-3">'+
                                        flag+
                                        '<div class="media-body">'+

                                        '<label class="titles">'+value.filename+'</label>'+
                                        '<div class="viewbutton">'+
                                        '<button class="btn btn-primary btn-sm">' +
                                        '<a href="'+value.url+'" target="_blank">View</a>'+
                                            '</button>'+
                                            '</div>'+
                                        '</div>'+
                                    '</div>'
                                ])
                            });
                        }
                    }
                });
            }
    </script>
    @endpush
