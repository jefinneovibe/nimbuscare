@extends('layouts.document_management_layout')

@section('settings')


<div class="section_details">
    <div class="card_header clearfix">
        <h3 class="title" style="margin-bottom: 8px;">Add Email </h3>
    </div>
    <div class="card_content">
        <div class="email_sec clearfix">
            <form id="add_credential">
                {{csrf_field()}}
                <input type="hidden" name="non_renew_total" id="non_renew_total" value="0">
                <input type="hidden" name="renew_total" id="renew_total" value="0">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form_group">
                            <label class="form_label">email id <span>*</span></label>
                        <input class="form_input" name="username" id="username" placeholder="email" value="" type="text" autocomplete="on">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form_group">
                            <label class="form_label">Password<span>*</span></label>
                            <input class="form_input" name="password" id="password" placeholder="Password" value="" type="password" autocomplete="on">
                        </div>
                    </div>
                </div> 
                <div class="row">
                    <div class="col-md-6">
                        <div class="form_group">
                            <label class="form_label">Confirm Password<span>*</span></label>
                            <input class="form_input" name="confirm_passWord" id="confirm_passWord" placeholder="Confirm Password" type="password" autocomplete="on">
                        </div>
                    </div>

                    {{-- <div class="col-md-6">
                            <div class="custom_checkbox">
                                <input type="checkbox" name="auto_renew" id="auto_renew" value="true" class="inp-cbx"  style="display: none">
                                <label for="auto_renew" class="cbx">
                                    <span style="min-width: 18px;">
                                        <svg width="10px" height="8px" viewBox="0 0 12 10">
                                            <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                        </svg>
                                    </span>
                                    <span>Renew Automatically</span>
                                </label>
                            </div>
                    </div> --}}

                </div>    
                <div class="row" style="margin-bottom: 20px;">
                    <div class="col-md-6">
                        <label class="form_label">Select Employee</label>
                        <select class="selectpicker" data-hide-disabled="true" data-live-search="true" name="assign_employee" id="assign_employee">
                            <option selected value="" name="assign">Select Employee</option>
                            @if(!empty($employees))
                                <option value="999">All</option>
                                @forelse($employees as $emp)
                                    <option value="{{$emp->_id}}">{{$emp->name}}</option>
                                @empty
                                    No employee available.
                                @endforelse
                            @endif
                        </select>
                    </div>
                    <div class="col-md-6">
                            <div class="custom_checkbox renew_checkbox">
                                <input type="checkbox" name="auto_renew" id="auto_renew" value="true" class="inp-cbx"  style="display: none">
                                <label for="auto_renew" class="cbx">
                                    <span style="min-width: 18px;">
                                        <svg width="10px" height="8px" viewBox="0 0 12 10">
                                            <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                        </svg>
                                    </span>
                                    <span>Renew Automatically</span>
                                </label>
                            </div>
                    </div>

                </div>
                <button class="btn btn-primary btn_action pull-right" id="button_submit" type="submit">Add Email</button> 
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

$('#add_credential').validate({
    rules:
    {
        username:
        {
            required:true,
            email: true
        },
        password: 
        {
            required: true,
        },
        confirm_passWord: 
        {
            required:true,
            equalTo: '#password'
        },
       
    },
    messages:
    {
        username: 
        {
            required: "Please enter email id",
            email: "please enter email id"
        },
        password: 
        {
            required: "Please enter password"
        },
        confirm_passWord:
        {
            required: "Please re-enter password",
            equalTo: "password mismatch"
        }
    },
    
    submitHandler: function(form)
    {
        var data=new FormData(form);
        $.ajax({
            type:"post",
            url:"{{url('enquiry/add-credentials')}}",
            contentType: false,       // The content type used when sending data to the server.
            cache: false,             // To unable request pages to be cached
            processData:false,
            data: data,
            success: function(result)
            {
                if(result==1)
                {
                    $('#message').text("Credentails successfully saved");
                    $('#message_popup .cd-popup').addClass('is-visible');
                }
                else if(result=="passFail")
                {
                    $('#messageStay').text("Password mismatch");
                    $('#message_stay_popup .cd-popup').addClass('is-visible');
                }
                else if(result==0)
                {
                    $('#messageStay').text("Email already exist");
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
    window.location.replace("{{url('enquiry/enquiry-view-settings')}}");
}

function hideMessageStay()
{
    $('#message_stay_popup .cd-popup').removeClass('is-visible');
    $('#messageStay').text(""); 
    $('#messageStay').html("");  
}

$(document).ready(function(){
    $('#username').val("");
    $('#password').val("");
    $('#confirm_passWord').val("");
});

function closeAdd()
{
    $('#username').val("");
    $('#password').val("");
    $('#confirm_passWord').val("");
    window.location="{{url('enquiry/enquiry-view-settings')}}";
}
</script>
@endpush
    
@endsection
