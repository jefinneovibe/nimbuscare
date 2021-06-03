@extends('layouts.document_management_layout')

@section('settings')


<div class="section_details">
    <div class="card_header clearfix">
        <h3 class="title" style="margin-bottom: 8px;">Group</h3>
    </div>
    <div class="card_content">
        <div class="email_sec clearfix">
            <form id="add_credential">
                {{csrf_field()}}
                <input type="hidden" name="credential_index" value="{{$data->_id}}">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form_group">
                            <label class="form_label">email id</label>
                            <span>{{$data->userID}}</span>
                        </div>
                    </div>
                </div> 

                <div class="row">
                        <div class="col-md-6 add_group">
                            @if(count(@$data->groups)>0)
                                <?php $count = 1; ?>
                                @foreach(@$data->groups as $group =>$groupData)
                            <div class="form_group clearfix">
                                @if($count==1)
                                    <label class="form_label">Add Group <span>*</span></label>
                                    @else
                                    <label class="form_label">Another Group Name<span>*</span></label>
                                @endif
                                <div class="table_div">
                                    <div class="table_cell">
                                    <input class="form_input txt_capitalize"  name="groupName[]" id="groupName{{$count}}"  placeholder="Enter Another Group Name" value="{{@$groupData}}" type="text">
                                    </div>
                                    <div class="table_cell">
                                        @if($count!=1)
                                            <div class="remove_btn rm-group"  data-toggle="tooltip" data-placement="bottom" data-container="body" data-original-title="Remove Group" onclick="removeToolTip('{{@$groupData}}')"><i class="fa fa-minus"></i></div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @if(count(@$data->groups)==$count)
                                <div id="append_group"></div>
                                <button class="add_another group" type="button" >Add Another Group Name</button>
                            @endif


                                    <?php $count++; ?>
                              @endforeach
                            @else
                                <div class="form_group clearfix">
                                    <label class="form_label">Add Group <span>*</span></label>
                                    <input class="form_input txt_capitalize"  name="groupName[]" id="groupName"  placeholder="Enter Group Name" type="text">
                                    <label id="groupName-error" class="error" style="display:none" for="groupName">Please enter group name</label>
                                    <div id="append_group"></div>
                                    <button class="add_another group" type="button" >Add Another Group Name</button>
                                </div>
                          @endif
                        </div>
                    </div>

                <div>
                    {{-- <label style="color:red;font-size: 12px;font-weight: 500;" id="status_error"></label> --}}
                </div>
                <?php
                if (count(@$data->groups)>0) {
                    $name="Update Group";
                } else {
                    $name="Add Group";
                }?>
                <button class="btn btn-primary btn_action pull-right" id="button_submit" type="submit">{{$name}}</button> 
                <button class="btn btn_cancel btn_action btn-cancel pull-right" type="button" onclick="closeAdd();">Back<div class="ripple-container"></div></button>    
            </form>
        </div>
    </div> 
</div>


{{-- message_popup pop up --}}
<div id="message_popup">
        <div class="cd-popup">
            <div class="cd-popup-container">
                <form method="post" >
                <div class="modal_content">
                    <div class="clearfix"></div>
                    <div class="content_spacing">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-12">
                                        <h3 name="message" id="message">..............</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal_footer">
                    <button class="btn btn-primary btn_action" type="button" onclick="hideMessage()">OK</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    {{-- message_popup pop up --}}

    {{-- message_popup pop up --}}
    <div id="message_stay_popup">
        <div class="cd-popup">
            <div class="cd-popup-container">
                <form method="post" >
                <div class="modal_content">
                    <div class="clearfix"></div>
                    <div class="content_spacing">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-12">
                                        <h3 name="messageStay" id="messageStay">..............</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal_footer">
                    <button class="btn btn-primary btn_action" type="button" onclick="hideMessageStay()">OK</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    {{-- message_popup pop up --}}




@push('scripts')
<script src="{{URL::asset('js/main/bootstrap-select.js')}}"></script>
<script>
function hideError(id)
{
    var splited=id.split("_");
    if(splited.length==3)
    {
        if($('#'+id).val()=='')
        {
            $('#non_renew_error_'+splited[2]).show();
        }else{
            $('#non_renew_error_'+splited[2]).hide();
        }
    } else if(splited.length==2){
        if($('#'+id).val()=='')
        {
            $('#renew_error_'+splited[1]).show();
        } else{
            $('#renew_error_'+splited[1]).hide();
        }
    }
}
function removeToolTip(index)
{
    $('[data-toggle="tooltip"]').tooltip('dispose');
    $('[data-toggle="tooltip"]').tooltip('enable');
}

$('#add_credential').validate({
    rules:
    {
        'groupName[]': {
            required:true,
        }
    },
    messages:
    {
        'groupName[]': 
        {
            required: "Please enter group name"
        }
    },
    errorPlacement: function (error, element) {
        error.insertAfter(element.parent().parent());
    },
    submitHandler: function(form)
    {
        if($('#groupName').val()==''){
            $('#groupName-error').show();
            return false;
        }
        var check=0;
        var data=new FormData(form);
        $.ajax({
            type:"post",
            url:"{{url('enquiry/add-group-data')}}",
            contentType: false,       // The content type used when sending data to the server.
            cache: false,             // To unable request pages to be cached
            processData:false,
            data: data,
            success: function(result)
            {
                if(result.success==true)
                {
                    $('#message').text("Updated successfully");
                    $('#message_popup .cd-popup').addClass('is-visible');
                }
            }
        });
    }
});

function hideMessage()
{
    $('#message_popup .cd-popup').removeClass('is-visible');
    $('#message').text(""); 
    $('#message').html("");  
    window.location.replace("{{url('enquiry/enquiry-view-settings')}}");
}
function closeAdd()
{
    window.location="{{url('enquiry/enquiry-view-settings')}}";
}

// var max_fields = 10; //maximum input boxes allowed
var wrapper_group = $(".add_group"); //Fields wrapper
var add_group_button = $(".group"); //Add button ID
var x = 1; //initlal text box count
$(add_group_button).click(function (e) { //on add another contact number
    e.preventDefault();
    // if (x < max_fields) { //max input box allowed
        x++; //text box increment
        $('#append_group').append(
            '<div class="form_group">'+
            '<label class="form_label">Another Group Name <span>*</span></label>' +
            '<div class="table_div">' +
            '<div class="table_cell">' +
            '<input class="form_input txt_capitalize"  name="groupName[]"  placeholder="Enter Another Group Name" id="groupName_'+x+'" type="text">' +
            '</div>'+//add input box
            '<div class="table_cell" >' +
            '<div class="remove_btn rm-group" data-toggle="tooltip" data-placement="bottom" data-container="body" data-original-title="Remove Group"><i class="fa fa-minus"></i></div>' +
            '</div>'+
            '</div>'+
            '</div>');
            $('[data-toggle="tooltip"]').tooltip('dispose');
            $('[data-toggle="tooltip"]').tooltip('enable');
            // $('[data-toggle="tooltip"]').tooltip();
    // }
    
});
$(wrapper_group).on("click", ".rm-group", function (e) { //user click on remove contact
    e.preventDefault();
    $(this).parent().parent().parent('div').remove();
    // $('[data-toggle="tooltip"]').tooltip('dispose');
    // $('[data-toggle="tooltip"]').tooltip('enable');
    $('.tooltip').hide();
    x--;
});

</script>
@endpush
    
@endsection
