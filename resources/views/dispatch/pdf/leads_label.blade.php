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

<div class="modal_content" style="background-color: #fff !important;">
    <div class="content_spacing" style="background-color: #fff !important;">
        {{--<div class="row">--}}
            {{--<div class="col-md-4">--}}
                <table class="export-table" style="width: 100%" border="1" bordercolor="white">
                    <?php
                    $i=1;
	                $len=sizeof($leadDetails);
                    $pagecount=$len/2;
                    $j=0;
                    $count=1;
                    ?>
                    @foreach(array_chunk($leadDetails,3) as $details)

                    <tr>
                        @foreach($details as $det)
                        <td class="align_center">
                            <h2>{{ucwords(strtolower($det['customer']['name']))}}</h2>
                            <h3>{{ucwords(strtolower($det['customer']['recipientName']))}}</h3>
                            @if(isset($det['dispatchDetails']['address']))
                            <p>{{ucwords(strtolower($det['dispatchDetails']['address']))}}</p>
                            @else
                                <?php
                                $customercode = $det['customer']['customerCode'];
                                $customer = \App\Customer::where('customerCode', $customercode)->first();
                                if (isset( $customer->addressLine2) && $customer->addressLine2 != '') {
                                    $address2 = ',' . $customer->addressLine2;
                                } else {
                                    $address2 = '';
                                }
                                if (isset( $customer->addressLine1) && $customer->addressLine1 != '') {
                                    $address1 = $customer->addressLine1;
                                } else {
	                                $address1 = '';
                                }
                                if(isset($customer->cityName) &&  $customer->cityName!='')
                                	{
		                                $cityName = ',' . $customer->cityName;
                                    }
                                    else{
	                                    $cityName ='';
                                    }
//                                $cityName = ',' . $customer->cityName;
                                $address = ucwords(strtolower($address1)) . ' ' . ucwords(strtolower($address2)) . ' ' . ucwords(strtolower($cityName));
                                ?>
                                    <p>{{$address}}</p>
                            @endif
                            @if($i%30==0)
                                {{--<div class="page-break"></div>--}}
                                <?php $j++; ?>
                                {{--@if($j<$pagecount)--}}
                                    {{--<div class="page-break" value="{{$j}}">--}}
                                    {{--</div>--}}
                                {{--@endif--}}
                            @endif
                            <?php  $i++; ?>
                        </td>
                            @endforeach
                    </tr>

        @endforeach
                </table>
            {{--</div>--}}
        {{--</div>--}}
    </div>
    {{--<div style="position: absolute;bottom: 10px; right: 10px; ">Internal</div>--}}
</div>

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
    .align_center{
        text-align: center;
        vertical-align: middle;
        padding: 25px 10px !important;
    }
    .align_center h2{
        font-weight: 600;
        margin: 0 0 2px;
        font-size: 20px;
    }
    .align_center h3{
        font-weight: 500;
        margin: 0 0 0px;
        font-size: 18px;
    }
    .align_center p{
        font-weight: 500;
        margin: 0 0 0px;
        font-size: 16px;
    }
    /*.content_spacing{*/
        /*page-break-after:always;*/
        /*position: relative;*/
    /*}*/
    body{
        margin: 0;
        padding: 0;
        width: 100%;
        height:auto;
    }
    /*.page-break {*/
        /*page-break-before: always;*/
    /*}*/
    /*@media print {*/
        /*.export-table {*/
            /*overflow: visible !important;*/
        /*}*/
    /*}*/
    thead {
        display: table-header-group;
    }
    tfoot {
        display: table-row-group;
    }
    tr {
        page-break-inside: avoid;
    }
</style>

</body>
</html>