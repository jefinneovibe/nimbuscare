@extends('layouts.document_management_layout')

@section('settings')


<div class="section_details">
    <div class="card_header clearfix">
        <h3 class="title" style="margin-bottom: 8px;">Status</h3>
    </div>
    <div class="card_content">
        <div class="email_sec clearfix">
            <form id="add_credential">
                {{csrf_field()}}
                <input type="hidden" id="credential_index" name="credential_index" value="{{$data->_id}}">
                <input type="hidden" name="total" id="total" value="0">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form_group">
                            <label class="form_label">email id <span>*</span></label>
                            <span>{{$data->userID}}</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form_label">Select Type <span>*</span></label>
                        <select class="selectpicker" name="type" id="type" onchange="getStatus(this);">
                            <option selected value="">Select Type</option>
                            <option value="Renewal">Renewal</option>
                            <option value="Non Renewal">Non Renewal</option>
                        </select>
                    </div>
                </div> 
                <div class="row">
                <div class="col-md-6" id="StatusDiv">
                </div>
                </div>
                <div>
                </div>
                <?php
                    $name="Update Status";
                ?>
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
                                        <h3 name="messageStay" id="messageStay">Updated successfully</h3>
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

    {{-- add sub status --}}
    <div id="addSubstatusPopUp">
        <div class="cd-popup">
            <div class="cd-popup-container">
                <form method="post" id="add_substatus_form">
                <input type="hidden" id="credential" name="credential" value="">
                <input type="hidden" id="typeselect" name="typeselect" value="">
                <input type="hidden" id="selectedStatus" name="selectedStatus" value="">
                    <div class="modal_content">
                        <div class="clearfix"></div>
                            <div class="content_spacing">
                                <div class="row">
                                    <div class="col-md-6" id="substatusDiv"></div>
                                </div>
                            </div>
                            <div class="modal_footer">
                            <button class="btn btn_cancel btn_action btn-cancel" type="button" onclick="closePop();">Back<div class="ripple-container"></div></button>    
                            <button class="btn btn-primary btn_action  pull-right" id="addSub" type="submit">Update Sub Status</button> 
                            </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- message_popup pop up --}}




@push('scripts')
<script src="{{URL::asset('js/main/bootstrap-select.js')}}"></script>
<script>
function displayPopUp(obj)
{
    $('#substatusDiv').html('');
    $('#credential').val('');
    $('#typeselect').val('');
    $('#selectedStatus').val('');
    var ids=obj.id;
    var splited=ids.split("_");
    if(splited.length==2){
        var status=$('#Status_'+splited[1]).val();
    } else if(splited.length==1){
        var check= ids.slice(12);
        var status= $('#Status'+check).val();
    }
    var id=$('#credential_index').val();
    var type=$('#type').val();
 
    $.ajax({
        type:"post",
        url:"{{url('enquiry/get-subStatus')}}",
        data:{
            id:id,
            selectedValue:status,
            selectedId:type,
            _token:'{{csrf_token()}}'
        },
        success:function(result){
            if(result.success==true){
                $('#substatusDiv').html(result.response);
                $('#credential').val(id);
                $('#typeselect').val(type);
                $('#selectedStatus').val(status);
                $('#addSubstatusPopUp .cd-popup').addClass('is-visible');
                $('[data-toggle="tooltip"]').tooltip();

            }
            
            else if(result.success==false){
                $('#substatusDiv').html('');
                $('#credential').val('');
                $('#typeselect').val('');
                $('#selectedStatus').val('');
            }
        }
    });



}

$('#add_substatus_form').validate({
    rules:
    {
        'subStatus[]': {
            required:function () {
                return ($("#type").val() =='Renewal');
            }
        },
        'subStatusNon[]': {
            required:function () {
                return ($("#type").val() =='Non Renewal');
            }
        }
    },
    messages:
    {
        'subStatus[]':"Please enter sub status name(Renewal)",
        'subStatusNon[]': "Please enter sub status name(Non Renewal)"
    },
    errorPlacement: function (error, element) {
        error.insertAfter(element);
              
    },
    submitHandler: function(form,event)
    {
        var form_data = new FormData($("#add_substatus_form")[0]);
        form_data.append('_token', '{{csrf_token()}}');
        $.ajax({
            type:"post",
            url:"{{url('enquiry/add-sub-status')}}",
            contentType: false,       // The content type used when sending data to the server.
            cache: false,             // To unable request pages to be cached
            processData:false,
            data: form_data,
            success: function(result)
            {
                if(result.success==true)
                {
                    $('#addSubstatusPopUp .cd-popup').removeClass('is-visible');
                    $('#message_stay').text("Updated successfully");
                    $('#message_stay_popup .cd-popup').addClass('is-visible');
                }
            }
        });
    }
});

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
                $('#StatusDiv').html(result.response);
                $('[data-toggle="tooltip"]').tooltip();
            }
            if(result.success==true && result.item=='nonRenew'){
                $('#StatusDiv').html(result.response);
                $('[data-toggle="tooltip"]').tooltip();
            }
            else if(result.success==false && result.item=='renew'){
                $('#StatusDiv').html('');
            }
            else if(result.success==false && result.item=='nonRenew'){
                $('#StatusDiv').html('');
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
function getStatus(obj){
    var id=$('#credential_index').val();
    var idStat=obj.id;
    $.ajax({
        type:"post",
        url:"{{url('enquiry/get-status')}}",
        data:{
            id:id,
            selectedValue:obj.value,
            _token:'{{csrf_token()}}'
        },
        success:function(result){
            if(result.success==true){
                $('#StatusDiv').html(result.response);
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
        'Status[]': {
            required:true
        },
        type: {
            required:true
        }
    },
    messages:
    {
        'Status[]':"Please enter status name",
        type:'Please select type'
            },
    errorPlacement: function (error, element) {
        if(element.attr("name") == "Status[]" )
                {
                    error.insertAfter(element.parent().parent());
                }
                else{
                    error.insertAfter(element.parent());
                }

    },
    submitHandler: function(form)
    {
        var form_data = new FormData($("#add_credential")[0]);
        form_data.append('_token', '{{csrf_token()}}');
        $.ajax({
            type:"post",
            url:"{{url('enquiry/add-status')}}",
            contentType: false,       // The content type used when sending data to the server.
            cache: false,             // To unable request pages to be cached
            processData:false,
            data: form_data,
            success: function(result)
            {
                if(result.success==true)
                {
                    $('#message').text("Status updated successfully");
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
    location.reload();
    // window.location.replace("{{url('enquiry/enquiry-view-settings')}}");
}
function hideMessageStay()
{
    $('#message_stay_popup .cd-popup').removeClass('is-visible');
    $('#message').text(""); 
    $('#message').html("");  
    // location.reload();
    // window.location.replace("{{url('enquiry/enquiry-view-settings')}}");
}
function closeAdd()
{
    $('#username').val("");
    $('#password').val("");
    $('#confirm_passWord').val("");
    window.location="{{url('enquiry/enquiry-view-settings')}}";
}
function closePop()
{
    $('#addSubstatusPopUp .cd-popup').removeClass('is-visible');
}

       

</script>
<style>
  #addSubstatusPopUp .cd-popup{
      z-index: 9999999;
  }  
</style>
@endpush
    
@endsection
