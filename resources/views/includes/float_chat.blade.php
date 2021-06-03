<!----------------------------------floating chat------------------------------------------->
<div class="floatingchat">
    <i class="fa fa-comments" aria-hidden="true"></i>
    <div class="chat">
        <div class="chatheader">
            <span class="chattitle">Comments</span>
            <button type="button" data-toggle="modal" data-target=""  onclick="select()">
                <i class="fa fa-user-plus" aria-hidden="true"  ></i>
                <!-- <i class="fa fa-user-plus" aria-hidden="true"  data-toggle="tooltip" data-placement="left" data-container="body" title="Give Permission"></i> -->
            </button>
            <button class="closechat">
                <i class="fa fa-times" aria-hidden="true" ></i>
                <!-- <i class="fa fa-times" aria-hidden="true" data-toggle="tooltip" data-placement="left" data-container="body" title="Close"></i> -->
            </button>
        </div>

        <ul class="messages"></ul>

        <div id="textFooterbox" class="chatfooter">
            <div onkeyup="checkInput(this)" class="text-box" id="text-box" contenteditable="true" disabled="true"></div>
            <button id="sendMessage">send</button>
        </div>
    </div>
</div>
<!----------------------------------floating chat- end------------------------------------------>

<!---------------------modal for chat---------------------------------------------------------->
<div class="modal fade" id="permission" tabindex="-1" role="dialog" aria-labelledby="permission" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-lg" role="document">
        <div class="modal-content  ">
            <div class="modal-header">
                <div class="row">
                    <div class="col-12">
                        <label class="titles"><b>Permission for comment notification</b></label>
                    </div>
                </div>
            </div>
            <div class="modal-body scrollstyle">
                <form id="permission_form" name="permission_form" method="post">
                    {{csrf_field()}}
                    <div class="col-md-12">
                        <label id="select_error" class="error"></label>
                    </div>
                    <div class=" container row checkboxred" id="user_list">

                    </div>
                </form>
            </div>
            <div class="commonbutton modal-footer">
                <button type="button" class="btn btn-link  ml-auto closebutton" data-dismiss="modal">CANCEL</button>
                <button type="button" class="btn btn-primary btnload" data-dismiss="modal" data-toggle="modal" data-target="" onclick="buttonSubmit()">UPDATE PERMISSION</button>
            </div>
        </div>
    </div>
</div>
<!---------------------------------mdal chat end-------------------------------------------->

@push('widgetScripts')

<script>

//---------------------------------------------------script for chat------------------

var element = $('.floatingchat');
    var myStorage = localStorage;

    if (!myStorage.getItem('chatID')) {
        myStorage.setItem('chatID', createUUID());
    }

    setTimeout(function() {
        element.addClass('enter');
    }, 1000);

    element.click(openElement);

    function openElement() {
        $('#validError').remove();
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
        element.find('.chatheader button').click(closeElement);
        element.find('#sendMessage').click(sendNewMessage);
        messages.scrollTop(messages.prop("scrollHeight"));
        var id  = $('#workTypeDataId').val();
        $.ajax({
            type: "GET",
            url: "{{url('get-chat-comment')}}",
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
                                '<h6>' + comment['commentBy'] + ' (' + comment['userType'] + ')</h6>',
                                comment['comment'],'<br>',
                                '<span class="date">' + comment['date'] + '</span>',

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
    function checkInput(t){
        if ($.trim($(t).text()) != ''){
            $('#validError').remove();
        }
    }
    function closeElement() {
        element.find('.chat').removeClass('enter').hide();
        element.find('>i').show();
        element.removeClass('expand');
        element.find('.chatheader button').off('click', closeElement);
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
        var userAuth = '{{ Auth::check() }}';
        if (userAuth == '') {
            location.href = '{{url('logout')}}';
        } else {

            if (userAuth == true) {
            $("#validError").remove();
            var userInput = $.trim($('#text-box').text());
            var newMessage = userInput.replace(/\<div\>|\<br.*?\>/ig, '\n').replace(/\<\/div\>/g, '').replace(/\n/g, '<br>');
            var messagesContainer = $('.messages');
            if (newMessage != '') {
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
                var id  = $('#workTypeDataId').val();
                messagesContainer.append([
                    '<div id="loader"><i class="fa fa-spinner fa-spin fa-3x fa-fw col-md-12 col-md-2 col-md-push-6" style="padding: 25px;"></i><span class="sr-only">Loading...</span></div>'
                ].join(''));
                $.ajax({
                    type: "GET",
                    url: "{{url('add-chat-comment')}}",
                    data:{comment : newMessage , date : strDate, id : id},
                    success: function(data){
                        if(data == "success")
                        {
                            $('#loader').remove();
                            $('#noc').remove();
                            <?php
                                if (\Illuminate\Support\Facades\Auth::user()) {
                                    @$loginName = \Illuminate\Support\Facades\Auth::user()->name;
                                } else {
                                    header("Location: url('/logout')");
                                }
                            ?>
                            messagesContainer.append([
                                '<li class="self">',
                                '<h6> <?php if (@$loginName) { echo \Illuminate\Support\Facades\Auth::user()->name; echo "(" .\Illuminate\Support\Facades\Auth::user()->roleDetail('name')['name'] .")";} else { header("Location: url('/logout')");} ?>  </h6>',
                                newMessage,'<br>',
                                '<span class="date">'+strDate+'</span>',
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
                /// clean out old message
                $('#text-box').html('');
                $('#text-box').focus();
                // focus on input
                //userInput.focus();

                messagesContainer.finish().animate({
                    scrollTop: messagesContainer.prop("scrollHeight")
                }, 250);
            } else {
                $("#textFooterbox").after([
                    '<label id="validError" class="error">Please enter a valid comment!</label>'
                ].join(''));
            }
        }
        }
    }

    function onMetaAndEnter(event) {
        if ((event.metaKey || event.ctrlKey) && event.keyCode == 13) {
            sendNewMessage();
        }
    }
    //script for right side bar----------------------



    // function openRightMenu() {
    // document.getElementById("rightMenu").style.display = "block";
    // }

    function closeRightMenu() {
    document.getElementById("rightMenu").style.display = "none";
    }


    //chat
    function select()
    {
        $('#user_list').html('<i class="fa fa-spinner fa-spin fa-3x fa-fw col-md-12 col-md-2 col-md-push-6" style="padding: 25px;"></i><span class="sr-only">Loading...</span>');
        var workTypeDataId = $('#workTypeDataId').val();
        $('#permission').modal();
        $.ajax({
            type:"GET",
            url:"{{url('get-chat-users')}}",
            data:{'workTypeDataId':workTypeDataId},
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
    function val()
    {
        $('#select_error').html('');
    }
    function buttonSubmit()
    {
        var length = $('input[name="users[]"]:checked').length;
        $('#permission_form').submit();
    }
    $('#permission_form').validate({
        submitHandler:function () {
            var form_data = new FormData($("#permission_form")[0]);
            form_data.append('_token', '{{csrf_token()}}');
            form_data.append('worktype_id', $('#workTypeDataId').val());
            $.ajax({
                url: '{{url('save-chat-permission')}}',
                data: form_data,
                method: 'post',
                cache: false,
                contentType: false,
                processData: false,
                success: function (result) {
                    if(result == 'success')
                    {
                        $('#permission').modal('hide');
                    } else {
                        $('#permission').modal();
                    }
                }
            });
        }
    });
</script>


@endpush
