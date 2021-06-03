<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Interactive Insurance Brokers LLC</title>

    <link rel="stylesheet" href="{{ URL::asset('css/bootstrap.min.css')}}"><!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ URL::asset('css/main/normalize.css')}}"><!-- Normalize CSS -->
    <link rel="stylesheet" href="{{ URL::asset('css/main/material-kit.css?v=2.0.3')}}" /><!-- Material Kit CSS -->
    <link rel="stylesheet" href="{{ URL::asset('css/main/main.css')}}"><!-- Main CSS -->

</head>
<body style="background-color: #fff;">


<div class="slip">
    <div class="modal_content">
        <h1>Dispatch / Collections Slip</h1>
        <hr>
        <div class="clearfix"></div>

        <div class="content_spacing">

            <table style="width: 100%;height: 987px;">
                <tr>
                    <td>
                        <div class="break">
                            <div class="row">
                                <div class="col-md-12">
                                    <table style="width: 100%">
                                        <tr>
                                            <td class="name"><label class="form_label">Customer Name </label></td>
                                            <td width="20">:</td>
                                            <?php
                                            $customer=$leadDetails->dispatchDetails->customer->name;?>
                                            <td><input type="text" class="form_input" readonly id="customerName" name="customerName" value="{{$customer}}"></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6" style="max-width: 380px;flex: 0 0 380px;">
                                    <table style="width: 100%">
                                        <tr>
                                            <td class="name"><label class="form_label">Reference Number </label></td>
                                            <td width="20">:</td>
		                                    <?php
		                                    $ref_number=$leadDetails->referenceNumber;?>
                                            <td><input type="text" class="form_input" value="{{$ref_number}}"></td>
                                        </tr>
                                        <tr>
                                            <td class="name"><label class="form_label">Customer ID </label></td>
                                            <td width="20">:</td>
                                            <td><input type="text"class="form_input" readonly id="customerCode" disabled name="customerCode" value="{{$leadDetails->dispatchDetails->customer->customerCode?:'--'}}"></td>
                                        </tr>
                                        <tr>
                                            <td class="name"><label class="form_label">Recipient Name </label></td>
                                            <td>:</td>
                                            <td><input type="text" class="form_input" id="recipientName" name="recipientName" value="{{$leadDetails->dispatchDetails->customer->recipientName}}"></td>
                                        </tr>
                                        <tr>
                                            <td class="name"><label class="form_label">Task Type </label></td>
                                            <td>:</td>
                                            <td><input type="text"class="form_input" id="taskType" name="taskType" value="{{$leadDetails->dispatchDetails->taskType->dispatchType}}"></td>
                                        </tr>
                                        <tr>
                                            <td class="name"><label class="form_label">Contact Number </label></td>
                                            <td>:</td>
                                            <td><input type="text" class="form_input" id="contactNum" name="contactNum" value="{{$leadDetails->dispatchDetails->contactNum}}"></td>
                                        </tr>
                                        <tr>
                                            <td class="name"><label class="form_label">Case Manager </label></td>
                                            <td>:</td>
                                            <td><input type="text"class="form_input" readonly id="caseManager" name="caseManager" value="{{$leadDetails->dispatchDetails->caseManager}}"></td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-md-6" style="max-width: 380px;flex: 0 0 380px;">
                                    <table style="width: 100%">
                                        <tr>
                                            <td class="name"><label class="form_label">Agent Name </label></td>
                                            <td width="20">:</td>
                                            <td><input type="text" class="form_input" readonly id="agentName" name="agentName" value="{{$leadDetails->dispatchDetails->agent}}"></td>
                                        </tr>
                                        <tr>
                                            <td class="name"><label class="form_label">Delivery Mode </label></td>
                                            <td>:</td>
                                            <td><input type="text" class="form_input" id="deliveryMode" name="deliveryMode" value="{{$leadDetails->dispatchDetails->deliveryMode->deliveryMode}}"></td>
                                        </tr>
                                        @if($leadDetails->dispatchDetails->deliveryMode->deliveryMode == 'Courier')
                                            <tr>
                                                <td class="name"><label class="form_label">Waybill Number </label></td>
                                                <td>:</td>
                                                <td><input type="text" class="form_input" id="waybillno" name="waybillno" value="{{$leadDetails->dispatchDetails->deliveryMode->wayBill}}"></td>
                                            </tr>
                                        @endif
                                        <tr>
                                            <td class="name"><label class="form_label">Assigned To </label></td>
                                            <td>:</td>
                                            <td><input type="text" class="form_input" id="employee_list" name="employee_list" value="{{$leadDetails->dispatchDetails->employee->name}}"></td>
                                        </tr>
                                        <tr>
                                            <td class="name"><label class="form_label">Email ID </label></td>
                                            <td>:</td>
                                            <td><input type="text" class="form_input" id="emailId" name="emailId" value="{{$leadDetails->dispatchDetails->emailId}}"></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <div style="height: 10px;"></div>
                            <div class="row">
                                <div class="col-md-12">
                                    <table style="width: 100%">
                                        <tr>
                                            <td class="name"><label class="form_label">Address </label></td>
                                            <td width="20">:</td>
                                            <td><p style="margin: 0" class="form_input">{{$leadDetails->dispatchDetails->address}}</p></td>
                                        </tr>
                                        <tr>
                                            <td class="name"><label class="form_label">Land Mark </label></td>
                                            <td>:</td>
                                            <td><input type="text" class="form_input" id="land_mark" name="land_mark" value="{{$leadDetails->dispatchDetails->land_mark}}"></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6" style="max-width: 380px;flex: 0 0 380px;">
                                    <table style="width: 100%">
                                        <tr>
                                            <td class="name"><label class="form_label">Preferred Del / Coll Date & Time: </label></td>
                                            <td width="20">:</td>
                                            <td><input type="text" class="form_input datetimepicker" id="date_time" name="date_time" value="{{$leadDetails->dispatchDetails->date_time}}"></td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-md-6" style="max-width: 380px;flex: 0 0 380px;"></div>
                            </div>

                            <table class="card_separation" style="margin: 20px -20px 0;padding: 10px 20px;width: 100%">
                                <tr>
                                    <th>
                                        <label class="form_label">Document Name </label>
                                    </th>
                                    <th>
                                        <label class="form_label"  id="amountlabel">Amount /No of Cards </label>
                                    </th>
                                    <th>
                                        <label class="form_label">Document Description </label>
                                    </th>
                                    <th>
                                        <label class="form_label">Type </label>
                                    </th>
                                    <th>
                                        <label class="form_label">Collected Amount </label>
                                    </th>
                                </tr>
                                <?php $i=0?>
                                @foreach($documentsList as $documents)
                                    @if(in_array($documents['id'],$documentSelectArray))
                                        <tr>
                                            <td>
                                                <input class="form_input" style="margin-bottom: 0" name="docName[]" id="docName" placeholder="Document Name"  value="{{$documents['documentName']?:'--'}}" type="text">
                                            </td>
                                            @if($documents['documentName']=="Cash" || $documents['documentName']=="Cheque" || $documents['documentName']=="Medical cards")
                                                <td id="amount" >
                                                    <input class="form_input" style="margin-bottom: 0" name="doc_amount[]" id="doc_amount" placeholder="Cheque / Cash amount" value="{{$documents['amount']?:'--'}}">
                                                </td>
                                            @else
                                                <td id="amount" >
                                                    <input class="form_input" style="margin-bottom: 0" name="doc_amount[]" id="doc_amount" placeholder="Cheque / Cash amount" value="--">
                                                </td>
                                            @endif
                                            <td>
                                                <p style="margin: 0" class="form_input">{{$documents['documentDescription']?:'--'}}</p>
                                            </td>
                                            <td>
                                                <input class="form_input" style="margin-bottom: 0" name="type[]" id="type" placeholder="Type"  value="{{$documents['documentType']?:'--'}}" type="text">
                                            </td>
                                            @if(($documents['documentName']=="Cash" || $documents['documentName']=="Cheque" || $documents['documentName']=="Medical cards"))
                                                <td>
                                                    @if(isset($documents['doc_collected_amount']))
                                                        <input class="form_input" style="margin-bottom: 0" name="doc_collected_amount[]" id="doc_collected_amount" placeholder="Collected Amount" value="{{$documents['doc_collected_amount']?:'--'}}">
                                                    @else
                                                        <input class="form_input" style="margin-bottom: 0" name="doc_collected_amount[]" id="doc_collected_amount" placeholder="Collected Amount" value="--">
                                                    @endif
                                                </td>
                                            @else
                                                <td>
                                                    <input class="form_input" style="margin-bottom: 0" name="doc_collected_amount[]" id="doc_collected_amount" placeholder="Collected Amount" value="--">
                                                </td>
                                            @endif
                                        </tr>

                                        <?php $i++;?>
                                    @endif
                                @endforeach
                            </table>
                        </div>
                    </td>
                </tr>
            </table>

            <div class="page-break"></div>


        </div>
        <div style="position: absolute;bottom: 10px; right: 10px; ">Internal</div>
    </div>
</div>

@if($print=='print_with' && @$leadDetails['comments'] !="" )
<div class="slip">
    <div class="modal_content">

        <h1>Dispatch / Collections Slip</h1>
        <hr>
        <div class="clearfix"></div>

        <div class="content_spacing">
            <table style="width: 100%">
                <tr>
                    <td>
                        <div class="break">

                            @if(@$leadDetails['comments'] !="")
                                <div class="chat_main">
                                    <header>
                                        <h3 class="card_sub_heading">Comments</h3>
                                    </header>

                                    <ul id="chat" style="overflow: auto;height: auto">
                                        <?php $count=0;?>
                                        @foreach(@$leadDetails['comments'] as $comments)
                                            <li class="you">
                                                <div class="entete">
                                                    <h3 style="font-style: italic;width: 100%;">  {{$comments['commentBy']}} - <span style="opacity: 1">{{$comments['date']}} - {{$comments['commentTime']}}</span> - <b style="font-style: normal">{{$comments['comment']}}</b></h3>
                                                </div>
                                            </li>
                                            <?php $count++;?>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif


                            <div class="bottom_view clearfix" style="display: none">
                                <div class="row">
                                    <div class="col-md-6">
                                        <table width="100%" style="margin-bottom: 60px">
                                            <tr>
                                                <td><label class="form_label">Received By </label></td>
                                                <td width="20">:</td>
                                                <td><input type="text" id="receivedBy" name="receivedBy" class="form_input"></td>
                                            </tr>
                                        </table>
                                        <small>(signature with date)</small>
                                    </div>
                                    <div class="col-md-6">
                                        <table width="100%" style="margin-bottom: 60px">
                                            <tr>
                                                <td><label class="form_label">Delivered By </label></td>
                                                <td width="20">:</td>
                                                <td><input type="text" id="deliveredBy" name="deliveredBy" class="form_input"></td>
                                            </tr>
                                        </table>
                                        <small>(signature with date)</small>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </td>
                </tr>
            </table>
            <div style="position: absolute;bottom: 0px; right: 10px; ">Internal</div>
        </div>

    </div>
</div>
@endif
{{--@endif--}}
<style>
    .card_separation .row .form_label{
        display: none;
    }
    .card_separation .row:first-child .form_label{
        display: block;
    }
    td.name{
        opacity: 1 !important;
    }
    .content_spacing{
        position: relative;
    }
    table.card_separation td {
        padding: 5px 12px;
    }
    table.card_separation th{
        border-bottom: 1px solid #ddd;
        padding: 8px 12px;
    }
    .page-break {
        page-break-before: always;
        overflow: hidden;
    }
    body{
        margin: 0;
        padding: 0;
        width: 100%;
        height:auto;
    }
    html, body, .layout_content{
        overflow: auto;
    }
    .break{

    }
</style>


</body>
</html>