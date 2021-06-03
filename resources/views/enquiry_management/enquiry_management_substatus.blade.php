@extends('layouts.document_management_layout')

@section('settings')


<div class="section_details">
    <div class="card_header clearfix">
        <h3 class="title" style="margin-bottom: 8px;">Sub Status</h3>
    </div>
    <div class="card_content">
        <div class="email_sec clearfix">
            <form id="add_credential">
                {{csrf_field()}}
                <input type="hidden" id="credential_index" name="credential_index" value="{{$data->_id}}">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form_group">
                            <label class="form_label">email id <span>*</span></label>
                            <span>{{$data->userID}}</span>
                        </div>
                    </div>
                </div> 

                <div class="row">
                    <div class="col-md-6">
                        <label class="form_label">Select Renewal Status <span>*</span></label>
                        <select class="selectpicker" data-hide-disabled="true" data-live-search="true" name="renewalStatus" id="renewalStatus" onchange="getSubStatus(this);">
                            <option selected value="">Select Renewal Status</option>
                            @if(!empty($renewSubStatus))
                                @forelse($renewSubStatus as $renew =>$renewStatus)
                                    <option value="{{$renewStatus['statusName']}}">{{$renewStatus['statusName']}}</option>
                                @empty
                                    No status available.
                                @endforelse
                            @endif
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form_label">Select Non Renewal Status <span>*</span></label>
                        <select class="selectpicker" data-hide-disabled="true" data-live-search="true" name="nonRenewalStatus" id="nonRenewalStatus" onchange="getSubStatus(this);">
                        <option selected value="">Select Non Renewal Status</option>
                            @if(!empty($nonRenewSubStatus))
                                @forelse($nonRenewSubStatus as $nonRenew => $nonRenewStatus)
                                    <option value="{{$nonRenewStatus['statusName']}}">{{$nonRenewStatus['statusName']}}</option>
                                @empty
                                    No status available.
                                @endforelse
                            @endif
                        </select>
                    </div>
                </div>
                <div class="row">
                <div class="col-md-6 add_Renewal" id="renewStatusDiv">
                </div>
                <div class="col-md-6 add_nonRenewal" id="nonRenewStatusDiv">
                </div>
                </div>
                <div>
                    {{-- <label style="color:red;font-size: 12px;font-weight: 500;" id="status_error"></label> --}}
                </div>
                <?php
                // if (count(@$count)>0) {
                //     $name="Update Substatus";
                // } else {
                    $name="Update substtaus";
                // }?>
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
function getSubStatus(obj){
var id=$('#credential_index').val();
var idStat=obj.id;
$.ajax({
    type:"post",
    url:"{{url('enquiry/get-subStatus')}}",
    data:{
        id:id,
        selectedValue:obj.value,
        selectedId:obj.id,
        _token:'{{csrf_token()}}'
    },
    success:function(result){
        if(result.success==true && result.item=='renew'){
            $('#renewStatusDiv').html(result.response);
        }
        if(result.success==true && result.item=='nonRenew'){
            $('#nonRenewStatusDiv').html(result.response);
        }
        else if(result.success==false && result.item=='renew'){
            $('#renewStatusDiv').html('');
        }
        else if(result.success==false && result.item=='nonRenew'){
            $('#nonRenewStatusDiv').html('');
        }
        var splited=idStat.split("_");
        if($('#'+idStat).val()=='')
        {
            $('#'+idStat+'-error').show();
        }else{
            $('#'+idStat+'-error').hide();
        }
   
    }


});
}


var maxIndex=0;
var count=1;


$('#add_credential').validate({
    rules:
    {
        'subStatus[]': {
            required:function () {
                return ($("#renewalStatus").val() !='');
            }
        },
        'subStatusNon[]': {
            required:function () {
                return ($("#nonRenewalStatus").val() !='');
            }
        },
        renewalStatus: {
            required:function () {
                return ($("#nonRenewalStatus").val() =='');
            }
        },
        nonRenewalStatus: {
            required:function () {
                return ($("#renewalStatus").val() =='');
            }
        }
    },
    messages:
    {
        'subStatus[]':"Please enter sub status name(Renewal)",
        'subStatusNon[]': "Please enter sub status name(Non Renewal)",
        nonRenewalStatus:'Please select non renewal status',
        renewalStatus:'Please select renewal status'
    },
    errorPlacement: function (error, element) {
        if(element.attr("name") == "renewalStatus"
                    || element.attr("name") == "nonRenewalStatus")
                {
                    error.insertAfter(element.parent());
                }
                else{
                    error.insertAfter(element.parent().parent().parent());
                }

    },
    
    submitHandler: function(form)
    {
        var check=0;
        var data=new FormData(form);
        $.ajax({
            type:"post",
            url:"{{url('enquiry/add-sub-status')}}",
            contentType: false,       // The content type used when sending data to the server.
            cache: false,             // To unable request pages to be cached
            processData:false,
            data: data,
            success: function(result)
            {
                if(result.success==true)
                {
                    $('#message').text("Added successfully");
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
    $('#username').val("");
    $('#password').val("");
    $('#confirm_passWord').val("");
    window.location="{{url('enquiry/enquiry-view-settings')}}";
}

       

</script>
@endpush
    
@endsection
