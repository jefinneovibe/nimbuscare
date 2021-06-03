@extends('layouts.document_management_layout')

@section('settings')
<div class="section_details">
    <div class="card_header clearfix">
        <h3 class="title" style="margin-bottom: 8px;">Edit Email</h3>
    </div>
    <div class="card_content">
        <div class="email_sec clearfix">
            <form id="edit_credential">
                {{csrf_field()}}
                <input type="hidden" name="credential_index" value="{{$data->_id}}">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form_group">
                            <label class="form_label">email id <span>*</span></label>
                            <input class="form_input" name="username" id="username" placeholder="email" value="{{$data->userID}}" type="text">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form_group">
                            <label class="form_label">Password<span>*</span></label>
                            <input class="form_input" name="password" id="password" placeholder="Password" value="{{$data->passWord}}" type="password">
                        </div>
                    </div>
                </div> 
                <div class="row">
                    <div class="col-md-6">
                        <div class="form_group">
                            <label class="form_label">Confirm Password<span>*</span></label>
                            <input class="form_input" name="confirm_passWord" id="confirm_passWord" placeholder="Confirm Password" value="{{$data->passWord}}" type="password">
                        </div>
                    </div>
                    <div class="col-md-6">
                            <label class="form_label">Select Employee</label>
                            <select class="selectpicker" data-hide-disabled="true" data-live-search="true" name="assign_employee" id="assign_employee">
                                <option selected value="" name="assign">Select Employee</option>
                                <option value="999" @if($data->assignEmployee=='999') selected @endif  name="">All</option>
                                @if(!empty($employees))
                                @forelse($employees as $emp)
                                    <option value="{{$emp->_id}}" @if($emp->_id== $data->assignEmployee) selected @endif>{{$emp->name}}</option>
                                @empty
                                    No employee available.
                                @endforelse
                            @endif
                            </select>
                        </div>
                </div>    
                {{-- <div class="form_group" style="margin-bottom: 12px;">
                    <label class="form_label" style="font-size: 16px;">Add Status<span></span></label>
                </div> --}}
                <div class="row" id="status_set">
                    @php
                        $statusList=$data->statusAvailable;
                        $statCount=count($statusList);
                        $lastIndex=$statCount-1;
                        $count=0;
                    @endphp
                    @foreach ($statusList as $status)
                        <div class="col-md-8" id="status_{{$count}}">
                            <div class="add_email">
                                <div class="form_group clearfix">
                                    <div class="media">
                                        <div class="media-body">
                                            <label class="form_label">status<span style="color:red;">*</span></label>
                                            <input class="form_input txt_capitalize" name="status_txt_{{$count}}" placeholder="Status Name" type="text" value="{{$status['statusName']}}">
                                            <div style="color:red;font-size: 12px;font-weight: 500;" id="status_error_{{$count}}"></div>
                                        </div>
                                        <div class="media-right">
                                            <div class="closure_checkbox">
                                                <input type="checkbox" name="cbx_closure[]" value="{{$count}}" id="cbx_{{$count}}" class="inp-cbx" {{($status['closureProperty']==1)? "checked" : ""}} style="display: none">
                                                <label for="cbx_{{$count}}" class="cbx">
                                                    <span>
                                                        <svg width="10px" height="8px" viewBox="0 0 12 10">
                                                                <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                                            </svg>
                                                    </span>
                                                    <span>Closure Behaviour</span>
                                                </label>
                                            </div>
                                        </div>
                                        <div id="append_status">
                                        </div>
                                        <div id="status_key">
                                            <div id="status_minus_{{$count}}" class="add_status_btn minus_icon" onclick="removeStatus('{{$count}}')"
                                            data-toggle="tooltip" data-placement="bottom" data-container="body" data-original-title="Remove Status">
                                                <a id="" >
                                                    <i class="fa fa-minus" style="color:white" aria-hidden="true"></i>
                                                </a>
                                            </div> 
                                            <div id="status_plus_{{$count}}" class="add_status_btn" style="display:none;" onclick="addStatus('{{$count}}')"
                                            data-toggle="tooltip" data-placement="bottom" data-container="body" data-original-title="Add Status">
                                                <a id="">
                                                    <i class="fa fa-plus" style="color:white" aria-hidden="true"></i>
                                                </a>
                                            </div>
                                        </div> 
                                    </div>
                                </div>
                            </div>
                        </div>
                        @php
                            $count++;
                        @endphp
                    @endforeach
                    <input type="hidden" name="total" id="total" value="{{$count-1}}">
                    
            </div>
                <button class="btn btn-primary btn_action pull-right" id="button_submit" type="submit">Update</button> 
                <button class="btn btn_cancel btn_action btn-cancel pull-right" onclick="viewPage()" type="button">Back<div class="ripple-container"></div></button>    
            </form>
        </div>
    </div> 
</div>


{{-- load spinner --}}
<div id="load_spinner" style="display:none;text-align:center;position:fixed;top: 49%;left: 46%;z-index:2;">
    <i class="fa fa-spinner fa-spin fa-3x fa-fw col-md-12 col-md-2 col-md-push-6" style="padding: 25px;color:#9c27b0;"></i>
    <span class="sr-only">Loading...</span>
</div>
{{-- load spinner --}} 


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
                    <button class="btn btn-primary btn_action" type="button" onclick="hideMessage()" id="message_remove">OK</button>
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
    var key;
    $(document).ready(function(){
        var key={{$lastIndex}};
        $('#status_plus_'+key).show();
        $('#status_minus_'+key).hide();
    });
// var count=1;

function viewPage()
{
    window.location="{{url('document/document-view-settings')}}";
}

$('#edit_credential').validate({
    rules:
    {
        username:
        {
            required: true,
            email: true
        },
        password:
        {
            required:true,
        },
        confirm_passWord: 
        {
            required:true,
            equalTo: '#password'
        }
    },
    messages:
    {
        username:
        {
            required: "Please enter email id",
            email: "Please enter email id"
        },
        password:
        {
            required: "Please enter password"
        },
        confirm_passWord:
        {
            required: "Please re-enter password",
            equalTo: "Password mismatch"
        }
        
    },
    submitHandler: function(form)
    {
        $('#load_spinner').show();
        var check=0;
        var total=Number($('#total').val());
        for(var i=0;i<=total;i++)
        {
            if($('input[name="status_txt_'+i+'"]').val()==""){
                $('#status_error_'+i).html("<span>Please enter status name</span>");
                ++check;
            }
        }
        for(var i=0;i<=total;i++)
        {
            if($('input[name="status_txt_'+i+'"]').val()!=""){
                $('#status_error_'+i).html("");
            }
        }
       
        if(check>0)
        {
            $('#load_spinner').hide();
            return;
        }

        var data=new FormData(form);
        // return;

        $.ajax({
            type:"post",
            url: "{{url('document/edit-credentials')}}",
            contentType: false,       // The content type used when sending data to the server.
            cache: false,             // To unable request pages to be cached
            processData:false,
            data: data,
            success: function(result)
            {
                $('#load_spinner').hide();
                if(result==1)
                {
                    $('#message').text("Updated successfully");
                    $('#message_popup .cd-popup').addClass('is-visible');
                }
                else if(result=='passFail')
                {
                    $('#message').text("Updated failed: password mismatch.");
                    $('#message_popup .cd-popup').addClass('is-visible');
                }
                else if(result==0)
                {
                    $('#messageStay').text('Email already exist');
                    $('#message_stay_popup .cd-popup').addClass('is-visible');
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
    window.location.replace("{{url('document/document-view-settings')}}");             
}

function hideMessageStay()
{
    $('#message_stay_popup .cd-popup').removeClass('is-visible');
    $('#messageStay').text(""); 
    $('#messageStay').html("");  
}

function addStatus(count)
{
    var index=Number(count)+1;
    var stat=index+1;
    maxIndex=index;

    $('#status_set').append(
        '<div class="col-md-8" id="status_'+index+'">'+
            '<div class="add_email">'+
                '<div class="form_group clearfix">'+
                    '<div class="media">'+
                        '<div class="media-body">'+
                            '<label class="form_label">Status<span>*</span></label>'+
                            '<input class="form_input txt_capitalize" name="status_txt_'+index+'" placeholder="Status Name" type="text" >'+
                            '<div style="color:red;font-size: 12px;font-weight: 500;" id="status_error_'+index+'"></div>'+
                        '</div>'+
                        '<div class="media-right">'+
                            '<div class="closure_checkbox">'+
                                '<input type="checkbox" name="cbx_closure[]" value="'+index+'" id="cbx_'+index+'" class="inp-cbx" style="display: none">'+
                                '<label for="cbx_'+index+'" class="cbx">'+
                                    '<span>'+
                                        '<svg width="10px" height="8px" viewBox="0 0 12 10">'+
                                            '<polyline points="1.5 6 4.5 9 10.5 1"></polyline>'+
                                        '</svg>'+
                                    '</span>'+
                                    '<span>Closure Behaviour</span>'+
                                '</label>'+
                            '</div>'+
                        '</div>'+
                        '<div id="append_status">'+
                        '</div>'+
                        '<div id="status_key_'+index+'">'+
                            '<div id="status_minus_'+index+'" class="add_status_btn minus_icon" style="display:none;" onclick="removeStatus(\''+index+'\')"'+
                            'data-toggle="tooltip" data-placement="bottom" data-container="body" data-original-title="Remove Status">'+
                                '<a id="" >'+
                                    '<i class="fa fa-minus" style="color:white" aria-hidden="true"></i>'+
                                '</a>'+
                            '</div> '+
                            '<div id="status_plus_'+index+'" class="add_status_btn" onclick="addStatus(\''+index+'\')"'+
                            'data-toggle="tooltip" data-placement="bottom" data-container="body" data-original-title="Add Status">'+
                                '<a id="" >'+
                                    '<i class="fa fa-plus" style="color:white" aria-hidden="true"></i>'+
                                '</a>'+
                            '</div>'+
                        '</div>'+ 
                    '</div>'+
                '</div>'+
            '</div>'+
        '</div>'
    );
    $('#total').val(index);
    $('#status_minus_'+count).show();
    $('#status_plus_'+count).hide();
    $('[data-toggle="tooltip"]').tooltip();
}

function removeStatus(index)
{
    $('#status_'+index).fadeOut('slow',function(){
        $('[data-toggle="tooltip"]').tooltip('dispose');
        $('#status_'+index).remove();
        $('[data-toggle="tooltip"]').tooltip('enable');    
        // $('[data-toggle="tooltip"]').tooltip();    
    });
}
</script>
@endpush
    
@endsection