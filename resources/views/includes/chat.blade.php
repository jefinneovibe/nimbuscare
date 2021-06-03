{{--Give permission popup--}}

<div id="permission">
    <div class="cd-popup">
        <div class="cd-popup-container">
            <div class="modal_content">
                <div class="clearfix">
                    <h1>Permission for comment notification</h1>
                </div>
                <form id="permission_form" name="permission_form" method="post">
                    {{csrf_field()}}
                    <div class="content_spacing">
                            <div class="row">
                                    <div class="col-md-12">
                                        <label id="select_error" class="error"></label>
                                    </div>
                                </div>
                        <div class="row">
                            <div class="col-md-12" id="user_list">
                                <i class="fa fa-spinner fa-spin fa-3x fa-fw col-md-12 col-md-2 col-md-push-6" style="padding: 25px;"></i><span class="sr-only">Loading...</span>
                            </div>
                        </div>
                    </div>
                    <div class="modal_footer">
                        <button class="btn btn-primary btn-link btn_cancel" type="button">Cancel</button>
                        <button type="button" class="btn btn-primary btn_action" onclick="buttonSubmit()">Update Permission</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{--Success popup--}}

<div id="success">
    <div class="cd-popup">
        <div class="cd-popup-container">
            <div class="modal_content">
                <div class="clearfix">
                </div>
                <div class="content_spacing">
                    <div class="row">
                        <div class="col-md-12" id="user_list">
                            <h3>Permission Updated Successfully</h3>
                        </div>
                    </div>
                </div>
                <div class="modal_footer">
                    <button type="button" class="btn btn-primary btn_cancel">OK</button>
                </div>
            </div>
        </div>
    </div>
</div>
{{--File viewer--}}
<a data-toggle="tooltip" data-placement="left" data-container="body" data-original-title="View & Upload Files" href="#0" class="cd-btn js-cd-panel-trigger" data-panel="main" onclick="loadFiles()"><i class="material-icons">cloud_upload</i></a>

<div class="cd-panel cd-panel--from-right js-cd-panel-main">
    <header class="cd-panel__header">
        <h2>File Upload</h2>
        <a href="#0" class="cd-panel__close js-cd-close" data-toggle="tooltip" data-placement="left" data-container="body" data-original-title="Close" >Close</a>
    </header>
    <div class="cd-panel__container">
        <div class="cd-panel__content">


            <div class="row">
                <div class="col-md-12">

                    <div class="uploaded_list">
                        <label id ="upload_list" class="form_label">List of uploaded files</label>
                        <ul id="file_view">
                            <div id="load"><i class="fa fa-spinner fa-spin fa-3x fa-fw col-md-12 col-md-2 col-md-push-6" style="padding: 25px;"></i><span class="sr-only">Loading...</span></div>
                        </ul>
                    </div>
                    <form id="upload_file_form" name="upload_file_form" method="post">
                    <div class="form_group file_upload_demo">
                        <label class="form_label">Upload documents</label>
                        <input id="demodocs" type="file" name="documents[]" accept=".pdf, .jpg, .png, image/jpeg, image/png" multiple>

                        {{--<input id="documents" type="file" name="files" accept=".pdf, .jpg, .png, image/jpeg, image/png" multiple>--}}
                    </div>
                    <div class="modal_footer">
                        <button type="button" class="btn blue_btn" id="button_submit_fileupload">Upload</button>
                    </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
<style>
    .tooltip {
        z-index: 99999999;
    }
</style>
@push('scripts')
    <!--jquery validate-->
    <script src="{{URL::asset('js/main/jquery.validate.js')}}"></script>
    <script src="{{URL::asset('js/main/additional-methods.min.js')}}"></script>

    <!-- Fancy FileUpload -->
    <script src="{{URL::asset('js/file-uploader/jquery.ui.widget.js')}}"></script>
    <script src="{{URL::asset('js/file-uploader/jquery.fileupload.js')}}"></script>
    <script src="{{URL::asset('js/file-uploader/jquery.iframe-transport.js')}}"></script>
    <script src="{{URL::asset('js/file-uploader/jquery.fancy-fileupload.js')}}"></script>
    {{--Chat box--}}
    <div class="floating-chat">
        <i class="fa fa-comments" data-toggle="tooltip" data-placement="left" data-container="body" data-original-title="View & Add Comments" style="position: absolute;width: 100%;height: 100%;line-height: 55px;text-align: center;" aria-hidden="true"></i>
        <div class="chat">
            <div class="header">
                <span class="title">Comments</span>
                @if(\Illuminate\Support\Facades\Auth::check())
                    @if($pipeline_details->createdBy['id']==\Illuminate\Support\Facades\Auth::id())
                        <a class="multi_user" onclick="select()">
                            <i  data-toggle="tooltip" data-placement="left" data-container="body" data-original-title="Give Permission" class="material-icons">person_add</i>
                        </a>
                    @endif
                @endif
                <button  data-toggle="tooltip" data-placement="left" data-container="body" data-original-title="Close">
                    <i class="fa fa-times" aria-hidden="true"></i>
                </button>
            </div>
            <ul class="messages"></ul>
            <div id="load"></div>
            <div class="footer">
                <textarea id="text-box" class="text-box" contenteditable="true" disabled="true"></textarea>
                <button id="sendMessage">send</button>
            </div>
        </div>
    </div>
        <script>
            var permission = 0;
            var element = $('.floating-chat');
            var myStorage = localStorage;

            if (!myStorage.getItem('chatID')) {
                myStorage.setItem('chatID', createUUID());
            }

            setTimeout(function() {
                element.addClass('enter');
            }, 1000);

            element.click(openElement);

            function openElement() {
                var messagesContainer = $('.messages');
                messagesContainer.html('<i class="fa fa-spinner fa-spin fa-3x fa-fw col-md-12 col-md-2 col-md-push-6" style="padding: 25px;"></i><span class="sr-only">Loading...</span>')
                var i;
                var comment;
                var messages = element.find('.messages');
                var textInput = element.find('.text-box');
                element.find('>i').hide();
                element.addClass('expand');
                element.find('.chat').addClass('enter');
                var strLength = textInput.val().length * 2;
                textInput.keydown(onMetaAndEnter).prop("disabled", false).focus();
                element.off('click', openElement);
                element.find('.header button').click(closeElement);
                element.find('#sendMessage').click(sendNewMessage);
                messages.scrollTop(messages.prop("scrollHeight"));
                var id  = $('#pipeline_id').val();
                $.ajax({
                    type: "GET",
                    url: "{{url('get-comment')}}",
                    data:{id : id},
                    dataType: 'json',
                    success: function(data){
                        messagesContainer.html('');
                        if(data)
                        {
                            for(i = 0; i<data.length; i++) {
                                comment = data[i];
                                if(comment['commentBy']!='') {
                                    messagesContainer.append([
                                        '<li class="self">',
                                        '<h2>' + comment['commentBy'] + ' (' + comment['userType'] + ')</h2>',
                                        '<span class="date">' + comment['date'] + '</span>',
                                        comment['comment'],
                                        '</li>'
                                    ].join(''));
                                }
                            }
                            messagesContainer.finish().animate({
                                scrollTop: messagesContainer.prop("scrollHeight")
                            }, 250);
                        }
                        else{
                            messagesContainer.append([
                                '<li id="noc" class="self">No Comments Available</li>'
                            ].join(''));
                        }
                    }
                });
            }

            function closeElement() {
                var messages = element.find('.messages');
                messages.html("");
                element.find('.chat').removeClass('enter').hide();
                element.find('>i').show();
                element.removeClass('expand');
                element.find('.header button').off('click', closeElement);
                element.find('#sendMessage').off('click', sendNewMessage);
                element.find('.text-box').off('keydown', onMetaAndEnter).prop("disabled", true).blur();
                setTimeout(function() {
                    element.find('.chat').removeClass('enter').show()
                    element.click(openElement);
                }, 500);
            }

            function createUUID() {
                // http://www.ietf.org/rfc/rfc4122.txt
                var s = [];
                var hexDigits = "0123456789abcdef";
                for (var i = 0; i < 36; i++) {
                    s[i] = hexDigits.substr(Math.floor(Math.random() * 0x10), 1);
                }
                s[14] = "4"; // bits 12-15 of the time_hi_and_version field to 0010
                s[19] = hexDigits.substr((s[19] & 0x3) | 0x8, 1); // bits 6-7 of the clock_seq_hi_and_reserved to 01
                s[8] = s[13] = s[18] = s[23] = "-";

                var uuid = s.join("");
                return uuid;
            }

            function sendNewMessage() {
                if ({{ Auth::check() }} == true) {
                var userInput = $('#text-box').val();
                var newMessage = userInput.replace(/(<([^>]+)>)/ig,"").replace(/\n/g, '<br>');

                if (!newMessage) return;

                var messagesContainer = $('.messages');
                var today = new Date();
                var dd = today.getDate();
                var mm = today.getMonth()+1;
                var yyyy = today.getFullYear();
                if(dd<10){
                    dd='0'+dd;
                }
                if(mm<10){
                    mm='0'+mm;
                }
                var strDate = dd + "-" + mm + "-" + yyyy;
                var id  = $('#pipeline_id').val();
                messagesContainer.append([
                    '<div id="loader"><i class="fa fa-spinner fa-spin fa-3x fa-fw col-md-12 col-md-2 col-md-push-6" style="padding: 25px;"></i><span class="sr-only">Loading...</span></div>'
                ].join(''));
                $.ajax({
                    type: "GET",
                    url: "{{url('add-comment')}}",
                    data:{comment : newMessage , date : strDate, id : id},
                    success: function(data){
                        if(data == "success")
                        {
                            $('#loader').remove();
                            $('#noc').remove();
                            messagesContainer.append([
                                '<li class="self">',
                                '<h2>{{\Illuminate\Support\Facades\Auth::user()->name}} ({{\Illuminate\Support\Facades\Auth::user()->roleDetail('name')['name']}})</h2>',
                                '<span class="date">'+strDate+'</span>',
                                newMessage,
                                '</li>'
                            ].join(''));
                        }
                        else{
                            $('#loader').remove();
                            messagesContainer.append([
                                '<li class="self">Comment sending failed!</li>'
                            ].join(''));
                        }
                    }
                });


                // clean out old message
                //userInput.html('');
                $('#text-box').val('');
                $('#text-box').focus();
                // focus on input
                //userInput.focus();

                messagesContainer.finish().animate({
                    scrollTop: messagesContainer.prop("scrollHeight")
                }, 250);
               }
            }

            function onMetaAndEnter(event) {
                if ((event.metaKey || event.ctrlKey) && event.keyCode == 13) {
                    sendNewMessage();
                }
            }
            function select()
            {
                $('#user_list').html('<i class="fa fa-spinner fa-spin fa-3x fa-fw col-md-12 col-md-2 col-md-push-6" style="padding: 25px;"></i><span class="sr-only">Loading...</span>');
                var pipeline_id = $('#pipeline_id').val();
                $('#permission .cd-popup').addClass('is-visible');
                $.ajax({
                    type:"GET",
                    url:"{{url('get-users')}}",
                    data:{'pipeline_id':pipeline_id},
                    success:function(data){
                        if(data)
                        {
                            $('#user_list').html('');
                            $('#user_list').append(data);
                            var d = $('input[name="users[]"]:checked').length;
                            if(d>0)
                            {
                                permission = 1;
                            }
                            else
                            {
                                permission = 0;
                            }
                        }
                    }
                });
            }
            $('#permission_form').validate({
                submitHandler:function () {
                    $('#preLoader').show();
                    var form_data = new FormData($("#permission_form")[0]);
                    form_data.append('_token', '{{csrf_token()}}');
                    form_data.append('worktype_id', $('#pipeline_id').val());
                    $.ajax({
                        url: '{{url('save-permission')}}',
                        data: form_data,
                        method: 'post',
                        cache: false,
                        contentType: false,
                        processData: false,
                        success: function (result) {
                            if(result == 'success')
                            {
                                $('#preLoader').fadeOut('slow');
                                $('#permission .cd-popup').removeClass('is-visible');
                                $('#success .cd-popup').addClass('is-visible');
                            }
                        }
                    });
                }
            });
            function  loaderShow() {
                $('#preLoader').show();
            }
        </script>
    <script src="{{URL::asset('js/main/side_panel.js')}}"></script>

    <script>
        var file_upload_length=0;
        $( "#button_submit_fileupload" ).click(function() {
            var valid_form=  $("#upload_file_form").valid();
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
                    $('#demodocs').next().find('.ff_fileupload_actions button.ff_fileupload_start_upload').click();return false;
                }
                else{
                    $('#upload_file_form').submit();
                }
            }
        });


        var output_url_file = [];
        var output_file_name = [];
        var output_file = [];
        var output_url = [];
        $(function() {
            $('#demodocs').FancyFileUpload({
                params: {
                    action: 'fileuploader'
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

        //Create work type form validation
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
                form_data.append('worktype_id', $('#pipeline_id').val());
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
                                    '<li>'+
                                    '<div class="media">'+
                                    flag+
                                    '<div class="media-body align-self-center">'+
                                    '<h5 class="mt-0">'+output_file_name[index]+'</h5>'+
                                    '</div>'+
                                    '<div class="ml-3 align-self-center"><a onclick=\"window.open(\''+value+'\', \n' +
                            '\'newwindow\', \n' +
                            '\'width=2000,height=1500\'); \n' +
                            'return false;\" target="_blank" href="'+value+'" class="btn btn-primary view_doc">View</a></div>'+
                                    '</div>'+
                                    '</li>'
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

        function loadFiles() {
            var pipeline_id = $('#pipeline_id').val();
            var flag;
            $.ajax({
                method:"GET",
                url:"{{url('get-files')}}",
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
                                '<li>'+
                                '<div class="media">'+
                                flag+
                                '<div class="media-body align-self-center">'+
                                '<h5 class="mt-0">'+value.filename+'</h5>'+
                                '</div>'+
                                '<div class="ml-3 align-self-center"><a onclick=\"window.open(\''+value.url+'\', \n' +
                                '\'newwindow\', \n' +
                                '\'width=2000,height=1500\'); \n' +
                                'return false;\" class="btn btn-primary view_doc">View</a></div>'+
                                '</div>'+
                                '</li>'
                            ])
                        });
                    }
                }
            });
        }
        function buttonSubmit()
        {
            var length = $('input[name="users[]"]:checked').length;
            // console.log(length);
            // if(length>0)
                $('#permission_form').submit();
        //     else
        //         $('#select_error').html('Please select a user');
        }
        function val()
        {
            $('#select_error').html('');
        }
    </script>
@endpush