@extends('layouts.dispatch_layout')
@section('content')
<div class="section_details">
    <div class="card_header clearfix">
        <h3 class="title" style="margin-bottom: 8px;">Create Lead</h3>
    </div>
    <div class="alert alert-danger alert-dismissible" role="alert" id="failed_customer" style="display: none">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        Lead adding failed.
    </div>
    {{--<div class="alert alert-danger alert-dismissible" role="alert" id="failed_customer" style="display: none">--}}
    {{--<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>--}}
    {{--Customer Adding failed.Department name duplicates--}}
    {{--</div>--}}
    <div class="card_content">
        <div class="edit_sec clearfix">
            <form method="post" name="lead_form" id="lead_form">
                {{ csrf_field() }}
                <input type="hidden" id="lead_id" name="lead_id">
                <input type="hidden" id="other_id" name="other_id" value="{{@$id}}">
                <input type="hidden" id="method" name="method" value="{{@$method}}">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form_group">
                            <label class="form_label">Select Type <span>*</span></label>
                            <div class="custom_select">
                                <select class="form_input" name="select_type" id="select_type" onchange="dropDownValidation(this);">
                                    <option selected value="" data-display-text="">Select Type</option>
                                    <option value="customer">Customer</option>
                                    <option value="recipient">Recipient</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8" id="customer_div">
                        <div class="form_group custom_dp">
                            <label class="form_label">Customer<span>*</span></label>
                            <select class="form-control" id="customerCode" name="customerCode" onchange="dropDownValidation(this)"></select>
                        </div>
                    </div>
                    <div class="col-md-8" id="recipient_div">
                        <div class="form_group custom_dp">
                            <label class="form_label">Name <span>*</span></label>
                            <select class="form-control" id="RecName" name="RecName" onchange="dropDownValidation(this)"></select>
                        </div>
                    </div>
                </div>


                <div class="row" id="customer_recipient_div">
                    <div class="col-md-12">
                        <div class="form_group">
                            <label class="form_label">Recipient Name<span>*</span></label>
                            <input class="form_input" name="recipientName" id="recipientName" placeholder="Recipient Name" value="{{@$customerDetails->firstName}}" type="text" onblur="dropDownValidation(this);">
                        </div>
                    </div>

                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form_group">
                            <label class="form_label">Contact Number<span>*</span></label>
                            <input class="form_input" name="contactNumber" id="contactNumber" placeholder="Contact Number" value="{{@$customerDetails->firstName}}" type="text" onblur="dropDownValidation(this);">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form_group">
                            <label class="form_label">Email ID<span>*</span></label>
                            <input class="form_input" name="contactEmail" id="contactEmail" placeholder="Email ID" value="{{@$customerDetails->firstName}}" type="text" onblur="dropDownValidation(this);">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6" id="agent_div">
                     <div class="form_group">
                        <label class="form_label">Agent<span>*</span></label>
                        <div class="custom_select agentDiv">
                            <select class="selectpicker" data-hide-disabled="true" data-live-search="true" name="agent" id="agent" onchange="dropDownValidation(this);">
                                <option selected value="" name="agent">Select Agent</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form_group">
                        <label class="form_label">Select Dispatch Type <span>*</span></label>
                        <div class="custom_select ">
                            <select class="form_input" name="dispatchType" id="dispatchType" onchange="dropDownValidation(this);">
                                <option selected value="" data-display-text="">Select Dispatch Type</option>
                                @if(!empty($dispatch_types))
                                @forelse($dispatch_types as $dispatch)
                                <option value="{{$dispatch->_id}}">{{@$dispatch->type}}</option>
                                @empty
                                No types found.
                                @endforelse
                                @endif
                            </select>
                        </div>
                    </div>
                </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form_group">
                    <label class="form_label">Delivery Mode<span>*</span></label>
                    <div class="custom_select ">
                        <select class="form_input" name="deliveryMode" id="deliveryMode" onchange="dropDownValidation(this);">
                            <option selected value="" data-display-text="">Select Delivery Mode</option>
                            @if(!empty($delivery_mode))
                            @forelse($delivery_mode as $delivery)
                            <option value="{{$delivery->_id}}">{{@$delivery->deliveryMode}}</option>
                            @empty
                            No types found.
                            @endforelse
                            @endif
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form_group">
                    <label class="form_label">Assigned To<span>*</span></label>
                    <div class="custom_select assignDiv">
                        <select class="selectpicker" data-hide-disabled="true" data-live-search="true" name="assign" id="assign" onblur="dropDownValidation(this);">
                            <option selected value="" name="assign">Select</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <button class="btn btn-primary btn_action pull-right" id="button_submit" type="submit">Next</button>
        </form>
    </div>
</div>
</div>
<div id="leave_popup">
    <div class="cd-popup">
        <div class="cd-popup-container">
            <div class="modal_content">
                <div class="clearfix"></div>
                <div class="content_spacing">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-12">
                                    <h3 style="font-size: 16px;margin: 10px 0;font-weight:  400;line-height: 23px;">This person is on leave till <span style="color: #0d6dea;" id="till_date"></span>.<br>Do you still want to assign it to the same person?</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal_footer">
                <button class="btn btn-primary btn-link" id="cancel_button">No</button>
                <button class="btn btn-primary btn_action" id="yes_button">Yes</button>
            </div>
        </div>
    </div>
</div>

<style>
    #customerCode-error,
    #RecName-error {
        position: absolute;
        bottom: -29px;
    }
</style>
@endsection

@push('scripts')
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>

<script src="{{URL::asset('js/main/jquery.validate.js')}}"></script>
<script src="{{URL::asset('js/main/custom-select.js')}}"></script>
<!-- Bootstrap Select -->
<script src="{{URL::asset('js/main/bootstrap-select.js')}}"></script>

<script>
    $('#customerCode').select2({
        ajax: {
            url: '{{URL::to('get-customers')}}',
            dataType: 'json',
            delay: 250,
            data: function(params) {
                return {
                    q: params.term, // search term
                    page: params.page
                };
            },
            processResults: function(data, params) {
                params.page = params.page || 1;
                return {
                    results: data.items,
                    pagination: {
                        more: (params.page * 10) < data.total_count
                    }
                };
            },
            cache: true
        },
        escapeMarkup: function(markup) {
            return markup;
        }, // let our custom formatter work
        templateResult: formatRepo,
        templateSelection: formatRepoSelection,
        placeholder: "Select customer name/code"

    });

    $('#RecName').select2({
        ajax: {
            url: '{{URL::to('get-recipients-list')}}',
            dataType: 'json',
            delay: 250,
            data: function(params) {
                return {
                    q: params.term, // search term
                    page: params.page
                };
            },
            processResults: function(data, params) {
                params.page = params.page || 1;
                return {
                    results: data.items,
                    pagination: {
                        more: (params.page * 10) < data.total_count
                    }
                };
            },
            cache: true
        },
        escapeMarkup: function(markup) {
            return markup;
        }, // let our custom formatter work
        templateResult: formatRepoRec,
        templateSelection: formatRepoSelectionCust,
        placeholder: "Select recipient name"

    });


    function formatRepo(repo) {
        if (repo.loading) {
            return repo.text;
        }
        if (repo.customerCode != '') {
            var markup = repo.fullName + ' (' + repo.customerCode + ')';
        } else {
            var markup = repo.fullName;
        }
        return markup;
    }

    function formatRepoRec(repo) {
        if (repo.loading) {
            return repo.text;
        }
        var markup = repo.fullName;
        return markup;
    }

    function formatRepoSelectionCust(repo) {
        if (repo.fullName) {
            return repo.fullName;
        } else {
            return repo.text;

        }
    }

    function formatRepoSelection(repo) {
        if (repo.fullName && repo.customerCode) {
            return repo.fullName + ' (' + repo.customerCode + ')';

        } else {
            return repo.text;

        }
    }

    $("#yes_button").click(function() {
        $("#leave_popup .cd-popup").removeClass('is-visible');
    });
    $("#cancel_button").click(function() {
        $("#leave_popup .cd-popup").removeClass('is-visible');
        $("#caseManager").val('default');
        $("#caseManager").selectpicker("refresh");

    });

    $('#customerCode').on('change', function() {
        $('#button_submit').attr('disabled', 'true');
        var customerCode = this.value;
        $.ajax({
            type: "POST",
            url: "{{url('dispatch/get-customer-details')}}",
            data: {
                type: 'customerCode',
                customerCode: customerCode,
                _token: '{{csrf_token()}}'
            },
            success: function(data) {
                if (data.success == true) {
                    $('#recipientName').val(data.CustomerDetails.fullName);
                    if (data.CustomerDetails.email) {
                        $('#contactEmail').val(data.CustomerDetails.email[0]);
                    }
                    $('#contactNumber').val(data.CustomerDetails.contactNumber[0]);
                    if (data.agent != '') {
                        $('#agent').attr("disabled", true);
                        $('#agent').selectpicker('destroy');
                        $('#agent').html(data.response);
                        $('#agent').selectpicker('setStyle');

                        $('#agent-error').hide();
                    } else {
                        $('#agent').attr("disabled", false);
                        $('#agent').selectpicker('destroy');
                        $('#agent').html(data.response);
                        $('#agent').selectpicker('setStyle');

                        $('#agent-error').hide();
                    }
                    //                       $('#customerName-error').hide();
                    $('#recipientName-error').hide();
                    $('#contactEmail-error').hide();
                    $('#contactNumber-error').hide();
                    $('#button_submit').removeAttr('disabled');
                }
            }
        });
    });
    $('#RecName').on('change', function() {
        $('#button_submit').attr('disabled', 'true');
        var rName = this.value;
        $.ajax({
            type: "POST",
            url: "{{url('dispatch/get-customer-details')}}",
            data: {
                type: 'recName',
                rName: rName,
                _token: '{{csrf_token()}}'
            },
            success: function(data) {
                if (data.success == true) {

                    $('#recipientName').val(data.CustomerDetails.fullName);
                    if (data.CustomerDetails.email) {
                        $('#contactEmail').val(data.CustomerDetails.email[0]);
                    }
                    $('#contactNumber').val(data.CustomerDetails.contactNumber[0]);
                    $('#agent').attr("disabled", false);
                    $('#agent').selectpicker('destroy');
                    $('#agent').html(data.response);
                    $('#agent').selectpicker('setStyle');
                    $('#agent-error').hide();
                    $('#recipientName-error').hide();
                    $('#contactEmail-error').hide();
                    $('#contactNumber-error').hide();
                    $('#button_submit').removeAttr('disabled');
                }
            }
        });
    });
    $('#deliveryMode').on('change', function() {
        var mode = $('#deliveryMode').val();
        var agent = $('#agent').val();
        $('#button_submit').attr('disabled', 'true');
        $.ajax({
            type: "POST",
            url: "{{url('dispatch/get-employees')}}",
            data: {
                mode: mode,
                agent: agent,
                _token: '{{csrf_token()}}'
            },
            success: function(data) {
                if (data.success == true) {
                    $('#assign').selectpicker('destroy');
                    $('#assign').html(data.response);
                    $('#assign').selectpicker('setStyle');
                    $('#assign-error').hide();
                    $('#button_submit').removeAttr('disabled');
                }
            }
        });

    });
    $(function() {
        $(window).load(function() {
            $('#preLoader').fadeOut('slow');
            // localStorage.clear();
        });
    });
    $.validator.addMethod("customemail",
        function(value, element) {
            return /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(value);
        },
        "Please enter a valid email id. "
    );

    //add leads form validation//
    $("#lead_form").validate({
        ignore: [],
        rules: {
            customerCode: {
                required: function() {
                    return $('#customer_div').is(':visible');
                }
            },
            //                customerName:  {
            //                    required: function(){
            //                        return $('#customer_div').is(':visible');
            //                    }
            //                },
            recipientName: {
                required: true
            },
            select_type: {
                required: true
            },
            caseManager: {
                required: true
            },
            agent: {
                required:function(){
                if($('#select_type').val() == "customer")
                    return true;
                else
                    return false;
            }
            },
            dispatchType: {
                required: true
            },
            deliveryMode: {
                required: true
            },
            assign: {
                required: true
            },
            contactNumber: {
                maxlength: 25,
                //                    minlength:10,
                required: true

            },
            contactEmail: {
                customemail: true,
                required: true
            },
            way_bill: {
                required: function() {
                    return $('#div_waybill').is(':visible');
                }
            },
            RecName: {
                required: function() {
                    return $('#recipient_div').is(':visible');
                }
            }
        },
        messages: {
            customerCode: "Please select customer name/code.",
            //                customerName: "Please select name.",
            recipientName: "Please enter recipient name.",
            caseManager: "Please select case manager.",
            agent: "Please select the agent.",
            dispatchType: "Please select dispatch type.",
            deliveryMode: "Please select delivery mode.",
            contactNumber: "Please enter valid contact number.",
            contactEmail: "Please enter valid email id.",
            assign: "Please select this field.",
            way_bill: "Please enter a waybill number.",
            select_type: "Please select type.",
            RecName: "Please select recipient name."
        },
        errorPlacement: function(error, element) {
            if (element.attr("name") == "RecName" || element.attr("name") == "customerCode") {
                error.insertAfter(element);
            } else if (element.attr("name") == "recipientName" || element.attr("name") == "contactNumber" ||
                element.attr("name") == "contactEmail") {
                error.insertAfter(element);
            } else {
                error.insertAfter(element.parent());
            }
        },
        submitHandler: function(form, event) {
            if ($('#agent').is(':disabled')) {
                $('#agent').attr("disabled", false);
            }
            var agentVal = $('#agent').val();
            var form_data = new FormData($("#lead_form")[0]);
            form_data.append('_token', '{{csrf_token()}}');
            form_data.append('agentVal', agentVal);
            $('#preLoader').show();
            $("#button_submit").attr("disabled", "disabled");
            //   var url="{{url('dispatch/dispatch-list')}}";
            $.ajax({
                method: 'post',
                url: '{{url('dispatch/save-lead')}}',
                data: form_data,
                cache: false,
                contentType: false,
                processData: false,
                success: function(result) {
                    if (result.success == true && result.save_method == 'Dispatch' && result.next_location == 'go_lead') {
                        window.location.href = '{{url('dispatch/dispatch-list')}}';
                    } else if (result.success == true && result.save_method == 'Dispatch' && result.next_location == 'go_reception') {
                        window.location.href = '{{url('dispatch/receptionist-list')}}';
                    } else if (result.success == true && result.save_method == 'pipeline') {
                        window.location.href = '{{url('pipelines')}}';
                    } else if (result.success == true && result.save_method == 'policy') {
                        window.location.href = '{{url('policies')}}';
                    } else if (result.success == true && result.save_method == 'pending-approval') {
                        window.location.href = '{{url('pending-approvals')}}';
                    } else if (result.success == true && result.save_method == 'pending-approval') {
                        window.location.href = '{{url('pending-approvals')}}';
                    } else if (result.success == true && result.save_method == 'pending-issuance') {
                        window.location.href = '{{url('pending-issuance')}}';
                    } else if (result.success == true && result.save_method == 'pending-issuance') {
                        window.location.href = '{{url('pending-issuance')}}';
                    } else if (result.success == false) {
                        $('#preLoader').hide();
                        $("#failed_customer").html('Sorry!You have already 20 leads in transferred list.Please close then you can create another lead.');
                        $("#failed_customer").show();
                        setTimeout(function() {
                            $('#failed_customer').fadeOut('fast');
                        }, 10000);
                        $("#button_submit").attr("disabled", false);
                    }
                }
            });
        }

    });
    //end//

    $(document).ready(function() {
        $('#customer_div').hide();
        $('#customer_recipient_div').hide();
        $('#recipient_div').hide();
    });

    $('#select_type').on('change', function() {
        var select_type = $('#select_type').val();
        if (select_type == 'customer') {
            $('#customer_div').show();
            $('#customer_recipient_div').show();
            $('#recipient_div').hide();
            $('#agent_div').show();
        } else if (select_type == 'recipient') {
            $('#recipient_div').show();
            $('#customer_div').hide();
            $('#agent_div').hide();
            $('#customer_recipient_div').show();
        }
    }); 
    /*
     * Custom dropDown validation*/

    function dropDownValidation(obj) {
        if ($('#customerName').val() != "") {
            $('#customerCode-error').hide();
        }
        $('#' + obj.id + '-error').hide()
    }

    function getActiveCaseManagers(caseManager) {
        $('#button_submit').prop('disabled', 'true');
        var caseManager = $('#' + caseManager).val();

        //            var caseManager = $("#caseManager :selected").val();
        if (caseManager == '') {
            $('#caseManager-error').show();
        } else {
            $('#caseManager-error').hide();
        }

        $.ajax({
            type: "post",
            url: "{{url('get-active-caseManager')}}",
            data: {
                'caseManager': caseManager,
                _token: '{{csrf_token()}}'
            },
            success: function(result) {
                if (result.status == 'leave') {
                    $("#leave_popup .cd-popup").toggleClass('is-visible');
                    $('#till_date').html(result.leave_date);
                }
                $('#button_submit').removeAttr("disabled");
            }
        });
    }

    function dropValidation() {
        $('#customerCode-error').hide();
    }
</script>
@endpush