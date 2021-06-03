<!DOCTYPE html>
<html lang="en">
    <head>
    <title>{{$title}}</title>
        <link rel="stylesheet" type="text/css" href="{{ URL::asset('widgetStyle/css/style.css?v1')}}">
        <link rel="shortcut icon" href="{{ URL::asset('img/favicon.png')}}">
    </head>
    <style>
    .flex_col {
        width: 50%;
        float: left;
    }
    .flex_col .title {
        padding: .65rem .75rem;
    }
    .flex_table{
        border: 1px solid #dee2e6;
        margin-top: 10px;
    }
    </style>
<body>

<div class="wrapper">
    <div id="pdfview">

        <table class="pdf_header">
            <tr>
                <td valign="middle">
                    <div class="pdf_title">
                        <h2>
                            Quotation for @if ($basicDetails['name'] != '')
                        {{$basicDetails['name']}}
                        @else
                            --
                        @endif
                        </h2>
                    </div>
                </td>
                <td align="right">
                    <img class="pdf_logo"  src="{{URL::asset('img/main/interactive_logo.png')}}">
                </td>
            </tr>
        </table>

        <div class="pdf_info">
            <table style="width: 100%;">
                <tbody >
                    <tr>
                        <td>
                            <label class="title">
                                <b class="red">Document ID : </b>
                                    @if ($basicDetails['refereneceNumber'] != '')
                                    {{ $basicDetails['refereneceNumber']}}
                                    @else
                                        --
                                    @endif
                                </label>
                            </td>
                            <td><label class="title"><b class="red">Prepared by :</b> INTERACTIVE Insurance Brokers LLC</label></td>
                        </tr>
                    <tr>
                        <td>
                            <label class="title"><b class="red">Prepared for :</b> @if ($basicDetails['customer'] != '')
                            {{$basicDetails['customer']}}
                            @else
                                --
                            @endif</label></td>
                            <td><label class="title"><b class="red">	Date :</b>  @if ($basicDetails['date']!='')
                                {{$basicDetails['date']}}
                                @else
                                    --
                                @endif</label></td>
                    </tr>
                    <tr>
                        <td colspan="2"><label class="title"><b class="red">Customer ID :</b>@if ($basicDetails['customer_id']!='')
                            {{$basicDetails['customer_id']}}
                            @else
                                --
                            @endif</label></td>
                    </tr>
                </tbody>
            </table>
            @if ($eQuotationData)
                <?php $pdfView = 0;?>
                @foreach ($eQuotationData['review'] as $reviewData1)
                    @if (isset($reviewData1['pdfView']) && $reviewData1['pdfView'])
                        <?php $pdfView++;?>
                    @endif
                @endforeach
                @if ($pdfView != 0)
                    <div class="flex_table">
                        @foreach ($eQuotationData['review'] as $reviewData)
                            @if (isset($reviewData['pdfView']) && $reviewData['pdfView'])
                                <?php @eval("\$toString = \"{$reviewData['value']}\";");?>
                                @if ($reviewData['type'] != 'cover')
                                    @if ($reviewData['type'] == 'AnnualWages')
                                        <?php @eval("\$str = \"{$reviewData['value']}\";"); ?>
                                        <?php @eval("\$str2 = \"{$reviewData['nonAdminValue']}\";"); ?>
                                        <?php @eval("\$status = \"{$reviewData['valueStatus']}\";"); ?>
                                        <div class="flex_col">
                                            <label class="title">
                                                <b class="red">{{htmlentities(@$reviewData['label'])}} : </b>
                                                @if(@$status == 'admin')
                                                    {{@$str}}
                                                @elseif(@$status == 'nonadmin')
                                                    {{@$str2}}
                                                @elseif(@$status == 'both')
                                                    {{@$str}}, {{@$str2}}
                                                @endif
                                            </label>
                                        </div>
                                    @elseif (isset($reviewData['isBusinessRelated']) && $reviewData['isBusinessRelated'])
                                        @if (count($reviewData['relatedBusiness']) > 0)
                                            @if (in_array (@$formValues['eQuestionnaire']['businessDetails']['businessType']['optionId'], $reviewData['relatedBusiness']))
                                                <div class="flex_col">
                                                    <label class="title">
                                                        <b class="red">{{htmlentities(@$reviewData['label'])}} : </b> {{htmlentities(@$toString)}}
                                                    </label>
                                                </div>
                                            @endif
                                        @endif
                                    @elseif (isset($reviewData['isWidgetRelated']) && $reviewData['isWidgetRelated'] === True)
                                        <?php @eval("\$str123_field = \"{$reviewData['checkValue']}\";");?>
                                        @if (in_array (@$str123_field, $reviewData['matchValue']))
                                            <div class="flex_col">
                                                <label class="title">
                                                    <b class="red">{{htmlentities(@$reviewData['label'])}} : </b> {{htmlentities(@$toString)}}
                                                </label>
                                            </div>
                                        @endif
                                    @else
                                        <div class="flex_col">
                                            <label class="title">
                                                <b class="red">{{htmlentities(@$reviewData['label'])}} : </b> {{htmlentities(@$toString)}}
                                            </label>
                                        </div>
                                    @endif
                                @endif
                            @endif
                        @endforeach
                        @foreach ($eQuotationData['review'] as $reviewData1)
                            @if (isset($reviewData1['pdfView']) && $reviewData1['pdfView'])
                                <?php @eval("\$toString = \"{$reviewData1['value']}\";"); ?>
                                @if ($reviewData1['type'] == 'cover')
                                    <div class="flex_col">
                                        <label class="title">
                                            <b class="red">{{htmlentities(@$toString?:$reviewData1['label'])}} : </b> {{htmlentities(@$reviewData1['statement'])}}
                                        </label>
                                    </div>
                                @endif
                            @endif
                        @endforeach
                        <br clear="all" />
                    </div>
                @endif
            @endif
            <table style="border: none">
                <tr><td style="padding: 5px"></td></tr>
            </table>
        </div>

        <div class="mycontainer">

            <div class="table-responsive">
                <div class="table-responsive">
                    <table width="95%" id="ecomptable" class=" comparison table table-bordered" cellpadding="0" cellspacing="0">
                        <thead>
                            <tr id="heading-row-qns">
                                <th class="mainsquestion" style="text-align: left;"><label style="font-size: 12px !important" class="titles blue">Clauses/Extensions</label></th>
                                @if($Insurer)
                                    @foreach(@$Insurer as $key =>$insuer)
                                        <th style="text-align: left"><label class="titles">{{$insuer['insurerDetails']['insurerName']}}</label> </th>
                                    @endforeach

                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @if($eQuotationData)
                                @foreach(@$eQuotationData['review'] as $review)
                                    @if($review['type'] == 'checkbox')
                                        <tr>
                                            <td class="mainsquestion"><label class="titles">{{htmlentities(@$review['label'])}}</label></td>
                                            @if($InsurerData)
                                                @foreach(@$InsurerData as $key =>$insurer1)
                                                        @foreach(@$insurer1 as $key1 =>$Insurerr12)
                                                            <td class="mainsquestion">
                                                                <label class="titles">
                                                                @if(@$review['fieldName'] == $key)
                                                                    @if(@$Insurerr12['agreeStatus'] == 'agreed')
                                                                        Covered
                                                                    @elseif(@$Insurerr12['agreeStatus'] == 'disagreed')
                                                                        Not covered
                                                                    @else
                                                                        {{htmlentities(@$Insurerr12['agreeStatus'])}}
                                                                    @endif
                                                                    <br>
                                                                    @if(@$Insurerr12['comments'])
                                                                        <span style="color:black;">{{htmlentities(@$Insurerr12['comments'])}}</span>
                                                                    @endif

                                                                @else
                                                                    <span class="removeTr" style="display:none"></span>
                                                                @endif
                                                                </label>
                                                            </td>
                                                        @endforeach
                                                @endforeach
                                            @endif
                                        </tr>
                                    @endif
                                @endforeach
                                @foreach(@$eQuotationData['forms'] as $forms)
                                    @if ($forms['fieldName'] != 'brokerage' )
                                        <tr>
                                            <td class="mainsquestion"><label class="titles">{{htmlentities(@$forms['label'])}}</label></td>
                                            @if($InsurerData)
                                            @foreach(@$InsurerData as $key =>$insurer2)
                                                    @foreach(@$insurer2 as $key1 =>$Insurerr21)
                                                        <td class="mainsquestion">
                                                            <label class="titles">
                                                                @if(@$forms['fieldName'] == $key)
                                                                    @if(@$Insurerr21['agreeStatus'] == 'agreed')
                                                                    Covered
                                                                @elseif(@$Insurerr21['agreeStatus'] == 'disagreed')
                                                                    Not covered
                                                                @else
                                                                    {{htmlentities(@$Insurerr21['agreeStatus'])}}
                                                                @endif
                                                                <br>
                                                                @if(@$Insurerr21['comments'])
                                                                    <span style="color:black;">{{htmlentities(@$Insurerr21['comments'])}}</span>
                                                                @endif
                                                            @else
                                                            <span class="removeTr" style="display:none"></span>
                                                            @endif
                                                            </label>
                                                        </td>
                                                    @endforeach
                                            @endforeach
                                            @endif
                                        </tr>
                                    @endif
                                @endforeach
                                {{-- @if(@$Insurer)
                                    <tr>
                                        <td>Customer Decision</td>
                           table                 @foreach(@$Insurer as $key =>$Insurer2)
                                                <td>
                                                    <div class="ans">
                                                        @if(@$Insurer2['customerDecision'])
                                                            {{@$Insurer2['customerDecision']['decision']}}
                                                            @if($Insurer2['customerDecision']['rejectReason'])
                                                                (Reason: {{@$Insurer2['customerDecision']['rejectReason']}} )
                                                            @endif
                                                            <br>
                                                            @if($Insurer2['customerDecision']['comment'])
                                                                Comment: {{@$Insurer2['customerDecision']['comment']}}
                                                            @endif
                                                        @else
                                                        --
                                                        @endif
                                                    </div>
                                                </td>
                                            @endforeach
                                    </tr>
                                @endif --}}
                            @endif
                        </tbody>
                    </table>


                </div>
            </div>
            @if ($Insurer)
            <h6 class="title" style="margin-top:10%;margin-bottom: 10px;">Insured/Client Decision</h6>
                <table style="width:100%; word-break:break-word;">
                    <tbody>
                        <tr>
                            <td class="titles" style="width:30% ;font-size: 13px; word-break:break-word;">Insurer</td>
                            <td class="titles" style="width:25%; font-size: 13px;word-break:break-word;">Decision</td>
                            <td class="titles" style="width:45%; font-size: 13px;word-break:break-word;"> Required amendments to the quotation (or reason for rejection if rejected)</td>
                        </tr>
                        @foreach ($Insurer as $insKey => $InsName)
                            <tr>
                                <td style="word-break:break-word;">
                                   <h6 style="margin:0px !important;"> {{$InsName['insurerDetails']['insurerName']}}</h6>
                                </td>
                                <td style="word-break:break-word;">
                                   <div class="decisionDiv">
                                        <div class="checkbox"></div><span>Approve</span>
                                        <div class="checkbox"></div><span>Approved with Amendement required</span>
                                        <div class="checkbox"></div><span>Reject</span>
                                   </div>
                                </td>
                                <td style="word-break:break-word;"></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
            <div class="row disclaimer">
                <div class="col-12">

                    <p class="red">
                        IMPORTANT: This document is the property of INTERACTIVE Insurance Brokers LLC, Dubai and is strictly confidential to its recipients.
                        The document should not be copied, distributed or reproduced in whole or in part, nor passed to any third party without the consent of its owner.
                    </p>
                    {{-- <p>Selected Insurer & Option : </p> --}}
                    <p>Signature : </p>
                    <p>Date : </p>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
table, tr, td, th, tbody, thead, tfoot {
    border-spacing: 0
}
.decisionDiv span{
    font-size: 11px;
    padding: 0px 4px 0px 4px;
    vertical-align: middle;
    position: relative;
    top: -3px;
}
/* .decisionDiv {
    display: inline-block !important;
} */
/* The standalone checkbox square*/
.decisionDiv .checkbox {
    width: 15px;
    height: 15px;
    border: 1px solid #000;
    display: inline-block;
}
.mailviewheader{
    position: relative !important;
}
body{
    background-color: #fff;
    margin: 0;padding: 0;
    line-height: 100%
}
table{
    border-collapse: collapse;
    border: 1px solid #dee2e6;
}
table thead{
    background-color: #f6f7fb;
}
table thead th {
    vertical-align: bottom;
    border-bottom: 2px solid #dee2e6;
}
table td, .table th {
    border: 1px solid #dee2e6;
}

table td, table th {
    padding: .75rem;
    vertical-align: top;
    border-top: 1px solid #dee2e6;
}
.pdf_info td{
    border: none;
    padding: .65rem .75rem;
    width: 50%;
}
.mycontainer{
    background: transparent;
    max-width: 100%
}
.titles span{
    color: #000;
}
.pdf_header{
    width: 100%;
    border: none;
    border: 1px solid #dee2e6;
}
.pdf_header td{
    border: none;
    padding: .75rem;
    background-color: #f6f7fb
}
.pdf_logo{
    width: 100px
}
.pdf_title h2{
    font-size: 18px;
    margin: 22px 0;
}
th .titles{
    font-size: 10px !important
}
</style>

<!-- jQuery -->
<script  src="{{ URL::asset('widgetStyle/js/main/jquery-2.2.4.min.js')}}"></script>
<script>
    $('.removeTr').parent().parent().remove();
</script>

</body>
</html>
