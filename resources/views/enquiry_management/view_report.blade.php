@extends('layouts.document_management_layout')

@section('settings')


<div class="section_details">
    <div class="card_header clearfix">
        <h3 class="title" style="margin-bottom: 8px;">View action level report </h3>
    </div>
    <div class="card_content">
        <div class="email_sec clearfix">
            <form id="view_report_form" name="view_report_form" type="get" action="{{url('enquiry/download-action-report')}}" target="_blank">
                {{csrf_field()}}
                <input type="hidden" name="non_renew_total" id="non_renew_total" value="0">
                <input type="hidden" name="renew_total" id="renew_total" value="0">
                <div class="row" style="margin-bottom:20px">
                    <div class="col-md-12">
                        <label class="form_label">Select mailbox<span>*</span></label>
                        <div class="custom_select_dropdown"> 
                            <select class="selectpicker" data-hide-disabled="true" data-live-search="true" name="selectMailBox" id="selectMailBox" onchange="validate(this.id);">
                                <option selected value="" name="assign">Select mail box</option>
                                @if(!empty($mailBoxes))
                                    @forelse($mailBoxes as $mailBox)
                                        <option value="{{$mailBox->_id}}">{{$mailBox->userID}}</option>
                                    @empty
                                        No mail box available.
                                    @endforelse
                                @endif
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form_group">
                            <label class="form_label">From date<span>*</span></label>
                            <input id="date_1" class="form_input date_font datetimepicker" name="fromDate"  placeholder="From Date" type="text">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form_group">
                            <label class="form_label">To date<span>*</span></label>
                            <input id="date_2" class="form_input date_font datetimepicker" name="toDate"  placeholder="To Date" type="text">
                        </div>
                    </div>
                </div> 
                <button class="btn btn-primary btn_action pull-right" id="button_submit" type="submit">View Report</button> 
                <button class="btn btn_cancel btn_action btn-cancel pull-right" type="button" onclick="closeAdd();">Back<div class="ripple-container"></div></button>    
            </form>
        </div>
    </div> 
</div>
@push('scripts')
<script src="{{URL::asset('js/main/bootstrap-select.js')}}"></script>
<script src="{{URL::asset('js/main/bootstrap-datetimepicker.js')}}"></script>

<script>
    // $('#view_report_form').validate();
    // if( $('#view_report_form').valid()==true)
    // {
       
    // }
    // $("#view_report_form").on("submit", function(){
    //         if( $('#view_report_form').valid()==true)
    //         {
    //             // location.reload();

    //         }
    // });
    var myForm=document.getElementById('view_report_form');
    myForm.addEventListener('submit',function(event){
    if( $('#view_report_form').valid()==true)
    {
        event.preventDefault();
        this.submit();//Submit the form BEFORE reloading
        location.reload(true);    
    }  
    },false);
  

$(function(){
   
    $('#date_1') .datetimepicker({
            format: 'DD/MM/YYYY',
            useCurrent: false 
    });
    $('#date_2') .datetimepicker({
            format: 'DD/MM/YYYY',
            useCurrent: false 
    });
    $('#date_1').on("dp.change", function (e) {
        $('#date_2').data("DateTimePicker").minDate(e.date);
        $('#date_2-error').hide();
    });
    $("#date_2").on("dp.change", function (e) {
        $('#date_1').data("DateTimePicker").maxDate(e.date);
    });
});
function closeAdd()
{
    window.location="{{url('enquiry/enquiry-dashboard')}}";
}
$('#view_report_form').validate({
    rules:
    {
        selectMailBox:
        {
            required:true
        },
        fromDate: 
        {
            required: true
        },
        toDate: 
        {
            required:true
        },
       
    },
    messages:
    {
        selectMailBox: 
        {
            required: "Please select mail box"
        },
        fromDate: 
        {
            required: "Please select from date"
        },
        toDate:
        {
            required: "Please select to date"
        }
    }
});
// $("#view_report_form").submit(function() {
//     $('#date_2').data("DateTimePicker").clear();
//     $('#date_2').data("DateTimePicker").clear();
// });
function validate(id)
{
    if($('#'+id).val()!='') {
        $('#'+id+'-error').hide();
    }
}
</script>
@endpush
    
@endsection
