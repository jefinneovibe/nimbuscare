<!doctype html>
<html lang="en" style="background-color: #fff !important;">
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
<body style="background-color: #fff !important;">

<div class="">
    <div class="modal_content">
        <?php $myDate = date('d/m/Y');;?>

        <table style="width: 100%">
            <tr>
                <td >
                    <h1 class="mn_heading" style="margin: 0">@if($path == "reception") Reception Log - (<?php echo $myDate;?>) @elseif($path == "schedule") Schedule Log - (<?php echo $myDate;?>) @else Dispatch / Collection Log - (<?php echo $myDate;?>)@endif</h1>
                </td>
                <td>
                    <div class="customer_logo">
                        <img src="{{URL::asset('img/main/interactive_logo.png')}}">
                    </div>
                </td>
            </tr>
        </table>

        <div class="clearfix"></div>

        <div class="content_spacing" style="background-color: #fff !important;">
            <div class="row">
                <div class="col-md-12">
                    <?php
                     $i=1;
	                $len=sizeof($leadDetails);
	                $pagecount=$len/2;
                     $j=0;
                     ?>
                        {{--@foreach($leadArray as $leadDetails)--}}
                         @foreach($leadDetails as $det)
                            @if($i%8==1)
                        <table style="width: 100%" border="1" bordercolor="black">
                        <tr>
                            <th>Date</th>
                            <th>Reference Number</th>
                            <th>Customer Name</th>
                            <th>Recipient Name</th>
                            <th>Contact Number</th>
                            <th>Dispatch Type</th>
                            <th>Customer/Recepient Address</th>
                            <th>Customer Signature / Date</th>
                        </tr>
                            @endif
                                <tr>
                                    <?php $date=date( "d/m/Y", strtotime($det['created_at']));?>
                                    <td valign="middle"> {{$date}}</td>
                                    <td valign="middle"> {{$det['referenceNumber']}}</td>
                                    <td valign="middle"> {{ucwords(strtolower($det['customer']['name']))}}</td>
                                    <td valign="middle"> {{ucwords(strtolower($det['customer']['recipientName']))}}</td>
                                    <td valign="middle"> {{$det['contactNumber']}}</td>
                                    <td valign="middle"> {{$det['dispatchType']['dispatchType']}}</td>
                                    <td valign="middle">
                                        @if(isset($det['dispatchDetails']['address']))
                                            <p>{{ucwords(strtolower($det['dispatchDetails']['address']))}}</p>
                                        @else
                                            <?php
                                            $customercode = $det['customer']['customerCode'];
                                            $customer = \App\Customer::where('customerCode', $customercode)->first();
                                            if (isset($customer->addressLine2) && $customer->addressLine2 != '') {
                                                $address2 = ',' . $customer->addressLine2;
                                            } else {
                                                $address2 = '';
                                            }
                                            if (isset($customer->addressLine1) && $customer->addressLine1 != '') {
                                                $addressLine1 = $customer->addressLine1;
                                            } else {
                                                $addressLine1 = '';
                                            }
                                            if(isset($customer->cityName) && $customer->cityName1='')
                                            {
                                                $cityName = ',' . $customer->cityName;
                                            } else{
                                                $cityName ='';
                                            }
                                           
                                            $address = ucwords(strtolower($addressLine1)) . '' . ucwords(strtolower($address2)) . '' .ucwords(strtolower($cityName));
                                            ?>
                                            <p>{{$address}}</p>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="height"></div>
                                    </td>
                                </tr>
                            @if($i%8==0)
                                {{--<div class="page-break"></div>--}}
                        <?php $j++; ?>
                        </table>
                                @if($j<$pagecount)
                                    <div class="page-break" value="{{$j}}">
                                    </div>
                                @endif
                            @endif
                          <?php  $i++; ?>
                        @endforeach
                            {{--@endforeach--}}

                </div>
            </div>

            <style>
                .height{
                    height: 70px;
                }
                .card_separation .row .form_label{
                    display: none;
                }
                .card_separation .row:first-child .form_label{
                    display: block;
                }
                td.name{
                    opacity: 1 !important;
                }
                 .page-break {
                     page-break-before: always;
                 }
                .content_spacing th, .content_spacing td{
                    padding: 6px 5px !important;
                    font-size: 14px;
                    font-weight: 500;
                    text-align: center;
                }
                .content_spacing th{
                    font-weight: 700;
                }
                .mn_heading{
                    font-weight: 700 !important;
                }
                .content_spacing{
                    /*page-break-after:always;*/
                    position: relative;
                }
                body{
                    margin: 0;
                    padding: 0;
                    width: 100%;
                    height:auto;
                }

            </style>
            <style type="text/css">
                table { page-break-inside:auto }
                tr    { page-break-inside:avoid; page-break-after:auto }
                thead { display:table-header-group }
                tfoot { display:table-footer-group }
            </style>
        </div>
    </div>
</div>
</body>
</html>