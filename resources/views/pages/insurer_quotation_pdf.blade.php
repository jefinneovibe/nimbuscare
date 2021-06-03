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
    .flex_col_full {
        width: 100% !important;
        float:initial !important;
        padding: .65rem .75rem;
    }
    .flex_col .title {
        padding: .65rem .75rem;
    }
    .roww .title {
        padding: .65rem .75rem;
    }
    h6 .title {
        padding: .65rem .75rem;
        font-size: 10px;
    }
    .fontBold{
        font-size: 12px !important;
        font-weight: 500 !important;
    }
    .flex_table{
        border: 1px solid #dee2e6;
        margin-top: 10px;
    }
    .flex_outDiv{       
        border: 0 !important;
    }
    .flex_table .title{
        font-size: 12px !important;
        font-weight: normal !important;
    }
    .child_space{
        margin-left: 10px;
    }
    .title_blue{
        color:#347abf;
    }
        .mainsanswer .ans {
    font-size: 12px;
    }
    .form-group table {
        margin-top: 15px
    }
    .claimhistorydata {
        margin-top: 20px;
        margin-bottom: 20px;
    }

    </style>
<body>

<div class="wrapper">
    <div id="pdfview" class="flex_col" style="display: inline-table;  border: 0;width: 99%;">
        <table class="pdf_header">
            <tr>
                <td valign="middle">
                    <div class="pdf_title">
                        <h2>
                            Broking Slip
                        </h2>
                    </div>
                </td>
                <td align="right">
                    <img class="pdf_logo"  src="{{URL::asset('img/main/interactive_logo.png')}}">
                </td>
            </tr>
        </table>
        <div class="pdf_info" style="padding: 5px;" >
            <table style="width: 99%;">
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
                            <td><label class="title"><b class="red">Prepared by :</b> Interactive Insurance Brokers LLC</label></td>
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
                        <td>
                            <label class="title"><b class="red">Customer ID :</b>
                                @if ($basicDetails['customer_id']!='')
                                {{$basicDetails['customer_id']}}
                                @else
                                    --
                                @endif
                            </label>
                        </td>
                        <td>
                            <label class="title"><b class="red">Insurer :</b>
                                @if ($insurer->name !='')
                                {{$insurer->name}}
                                @else
                                    --
                                @endif
                            </label>
                        </td>
                    </tr>
                </tbody>
            </table>
            <table style="border: none;padding: 5px;">
                <tr><td style="padding: 5px"></td></tr>
            </table>
            @if(@$data['eSlipData']['review'])
                <div class="flex_table" style="display: inline-block; width: 98%;padding: 5px; ">
                    <div style="display: inline-block; width: 95%;padding: 5px;">
                                @if (@$formValues->workTypeId['name'])
                                    <div class="flex_col">
                                        <label class="title"><b class="fontBold">Class of Business : {{@$formValues->workTypeId['name']}} </b></label>
                                    </div>
                                    @if(isset($formValues->eSlip['forms']['lastDate']) && !empty($formValues->eSlip['forms']['lastDate']))
                                        <div class="flex_col">
                                            <label class="title"><b class="fontBold">Last date for submitting the quotation: {{@$formValues->eSlip['forms']['lastDate']}}</b></label>
                                        </div>
                                    @endif
                                @endif
                                <?php $covers = []; $table = []; $claimHistoryView = []; $multiDocumentArr = [];?>
                                    @foreach(@$data['eSlipData']['review'] as $field)
                                            @if(strtolower($field['type']) == 'text')
                                                <?php @eval("\$str = \"{$field['value']}\";"); ?>
                                                @if(isset($field['sum']) && $field['sum'] == true)
                                                    <!-- Incase of sum value -->
                                                    <?php
                                                        $finalArray=array_map(function ($value) {
                                                            return str_replace(',', '', $value);
                                                        }, explode('|', $str));
                                                        $sum = array_sum($finalArray);
                                                        $str = number_format($sum);
                                                    ?>
                                                @endif 
                                                <div class="flex_col">
                                                    <label class="title" style="width:95%;"><b class="fontBold">{{$field['label']}}</b>  {{@$str?":$str" :""}}</label>
                                                    @if(!empty($field['statement']))
                                                        <div style="width:95%;"  class="disclaimer red spacing">
                                                            <p class="text-justify">{{$field['statement']}}</p>
                                                        </div>
                                                    @endif
                                                </div>  
                                            @elseif(strtolower($field['type']) == 'table')
                                                <?php $table[] =$field; ?>
                                            @elseif (strtolower($field['type']) == 'cover')
                                                <?php $covers[] = $field; ?>
                                            @elseif (strtolower($field['type']) == 'claimhistorymultipleview')
                                                <?php $claimHistoryView[] = $field; ?>
                                            @elseif (strtolower($field['type']) == 'annualwages')
                                                <?php @eval("\$str = \"{$field['value']}\";");?>
                                                <?php @eval("\$str2 = \"{$field['nonAdminValue']}\";"); ?>
                                                <?php @eval("\$status = \"{$field['valueStatus']}\";"); ?>
                                                <div class="flex_col">
                                                    @if(@$status == 'admin')
                                                        <label class="title"><b class="fontBold">{{$field['label']}}</b>: {{@$str}}</label>
                                                    @elseif(@$status == 'nonadmin')
                                                        <label class="title"><b class="fontBold">{{$field['label']}}</b>: {{@$str2}}</label>
                                                    @elseif(@$status == 'both')
                                                        <label class="title"><b class="fontBold">{{$field['label']}}</b>: {{@$str}},{{@$str2}}</label>
                                                    @endif
                                                </div>
                                            @endif
                                    @endforeach
                             <!--- </div> ----> 
                        @if (!empty($table))
                            @foreach ($table as $tableItem)
                                @if (isset($tableItem['table']) && !empty($tableItem['table']))
                                    <div class="flex_col_full" style="display: inline-block; ">
                                        @if (@$tableItem)
                                            <h6 style="color:#347abf;font-size: 12px;font-weight:600;" class="title">{{@$tableItem['label']}}</h6>
                                        @endif
                                        @if (isset($tableItem['table']) && !empty($tableItem['table']))
                                            @foreach ($tableItem['table'] as $tableArray)
                                                @if (isset($tableArray['isWidgetRelated']) && $tableArray['isWidgetRelated'] === True)
                                                    <?php @eval("\$str = \"{$tableArray['checkValue']}\";"); ?>                                       
                                                    @if (in_array (@$str, $tableArray['matchValue']))                                             
                                                        @if(isset($tableArray['value']) && !empty($tableArray['value']))
                                                            <?php $columnValue = @$tableArray['value']; ?>
                                                        @endif 
                                                    @else 
                                                        <?php $columnValue = "" ?>
                                                    @endif 
                                                @else
                                                <?php @eval("\$columnValue = \"{$tableArray['columnValue']}\";"); ?>
                                                @endif 
                                                
                                                @if (@$columnValue)
                                                    <div class="child_space">
                                                        <div class="flex_col">
                                                            <label class="title"><b class="fontBold">{{@$tableArray['columnName']}}</b>
                                                            : {{@$columnValue}}</label>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endforeach
                                        @endif
                                    </div>
                                @endif
                            @endforeach
                        @endif
                        @if (!empty($covers))
                            @foreach ($covers as $cover)
                                <div class="flex_col_full">
                                    @if ($cover['label'] != '')
                                        <h6 style="color:#347abf;font-size: 12px;font-weight:600; margin-bottom: 10px;" class="title">{{$cover['label']}}</h6>
                                    @endif
                                    <?php @eval("\$str = \"{$cover['value']}\";"); ?>
                                    @if (@$str)
                                        <label class="title child_space"><b>{{htmlentities(@$str)}}</b>
                                    @endif
                                    @if(!empty($cover['statement']))
                                        <div style="width:95%;" class="disclaimer red spacing child_space">
                                            <p class="text-justify">{{htmlentities($cover['statement'])}}</p>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        @endif
                     </div> 
                </div>
            @endif
        </div>

<!----------------------------------------------------------------claim history section--------------------------------------------------------->
        <div class="mycontainer" style="margin-top: 15px">
            @if(!empty(@$formData['claimsHistory']) && !isset($formData['claimsHistory']['type']))
                <div class="mycontainer">
                    <label><b class="title">Claim History</b></label>
                    <div class="flex_col_full">
                        <table style="width:99%;" class="claimhistorydata">
                            <thead>
                                @if (isset($formData['claimsHistory']))
                                    @foreach(@$formData['claimsHistory'] as $claimHistory1)
                                        @if($loop->iteration == 1)
                                            @foreach ($claimHistory1 as $key1 =>$val1)
                                                <th @if ($key1 == 'year')
                                                    style="width:10%;"
                                                @else
                                                style="width:40%;"
                                                @endif ><label class="titles">{{ucfirst(str_replace('_', ' ',  @$key1))}}</label></th>
                                            @endforeach
                                        @endif
                                    @endforeach
                                @endif
                            </thead>
                            <tbody>
                                @if (isset($formData['claimsHistory']))
                                    @foreach($formData['claimsHistory'] as $claimHistory)
                                        @if ((strtolower(@$formValues['eQuestionnaire']['businessDetails']['employeeDetails']['adminStatus'])== strtolower(preg_replace('/\s+/', '', @$claimHistory['type']))) || (strtolower(@$formValues['eQuestionnaire']['businessDetails']['employeeDetails']['adminStatus']) == 'both'))
                                            <tr>
                                                @foreach ($claimHistory as $key =>$val)
                                                    @if ($key == 'year')
                                                        <td>
                                                            {{str_replace('year', '',  @$claimHistory[$key])?:'--'}}
                                                            @if (str_replace('year', '',  @$claimHistory[$key]) == 1)
                                                                (Most Recent)
                                                            @endif
                                                        </td>
                                                    @else
                                                        <td><p>{{@$claimHistory[$key]?:'--'}}</p></td>
                                                    @endif
                                                @endforeach
                                            </tr>
                                        @endif
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            @else
                <div  style="margin-top: 15px" class="mycontainer">
                    <label><b class="title">Claim History</b></label>
                    @if (!empty($claimHistoryView))
                        @foreach ($claimHistoryView as $claimHistoryitem)
                            @if (!empty(@$formValues['eQuestionnaire']['policyDetails']['claimsHistory']))
                                <?php $selectedType = @$formValues['eQuestionnaire']['policyDetails']['claimsHistory']['type'] ?>
                                @if($selectedType == 'seperateData')
                                    <?php $loopFor = 2 ?>
                                @else
                                    <?php $loopFor = 1 ?>
                                @endif
                                @if ($selectedType != 'seperateData')
                                <br>
                                    <div class="flex_col_full">
                                        <label><b class="titles claimhistorydataTitile">{{@$claimHistoryitem['label'] ." ". @$claimHistoryitem['col_titles'][$selectedType]}}</b></label>
                                        <table style="width:99%;" class="claimhistorydata">
                                            <thead>
                                                    <th><label class="titles">Year</label></th>
                                                @if (@$claimHistoryitem['type_col'])
                                                    <th><label class="titles">Type</label></th>
                                                @endif
                                                @if (isset($claimHistoryitem['columns'][$selectedType]))
                                                    @foreach (@$claimHistoryitem['columns'][$selectedType] as $item)
                                                        <th><label class="titles">{{$item['label']}}</label></th>
                                                    @endforeach
                                                @endif
                                            </thead>
                                            <tbody>
                                                @foreach(@$formValues['eQuestionnaire']['policyDetails']['claimsHistory'] as $k=> $claimHistory)
                                                    @if(is_array($claimHistory))
                                                        <tr>
                                                            <td>{{$k}} &nbsp @if($loop->iteration == 2) (Most Recent) @endif </td>
                                                            @if (@$claimHistoryitem['type_col'])
                                                                <td>{{@$claimHistory['type']?:'--'}}</td>
                                                            @endif
                                                            @if (isset($claimHistoryitem['columns'][$selectedType]))
                                                                @foreach (@$claimHistoryitem['columns'][$selectedType] as $item1)
                                                                    <td><p>{{@$claimHistory[$item1['fieldname']]?:'--'}}</p></td>
                                                                @endforeach
                                                            @endif
                                                        </tr>
                                                    @endif
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                <br>
                                    <label><b class="titles claimhistorydataTitile">{{@$claimHistoryitem['label']}} Business interruption coverages</b></label>
                                    <div class="flex_col_full">
                                        <table style="width:99%;" class="claimhistorydata">
                                            <thead>
                                                <th><label class="titles">Year</label></th>
                                                @if (@$claimHistoryitem['type_col'])
                                                    <th><label class="titles">Type</label></th>
                                                @endif
                                                @foreach (@$claimHistoryitem['columns']['combinedData'] as $item)
                                                    <th><label class="titles">{{$item['label']}}</label></th>
                                                @endforeach
                                            </thead>
                                            <tbody>
                                                @foreach($formValues['eQuestionnaire']['policyDetails']['claimsHistory'] as $k=> $claimHistory)
                                                    @if(is_array($claimHistory))
                                                        <tr>
                                                            <td>{{$k}} &nbsp  @if($loop->iteration == 2)  (Most Recent) @endif </td>
                                                            @if (@$claimHistoryitem['type_col'])
                                                                <td>{{@$claimHistory['type']?:'--'}}</td>
                                                            @endif
                                                            @foreach ($claimHistoryitem['columns']['combinedData'] as $item1)
                                                                <td><p>{{@$claimHistory[$item1['fieldname']]?:'--'}}</p></td>
                                                            @endforeach
                                                        </tr>
                                                    @endif
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <br>
                                    <div class="flex_col_full">
                                        <label><b class="titles claimhistorydataTitile">{{@$claimHistoryitem['label'] ." ". @$claimHistoryitem['col_titles']['onlyFirePerils']}}</b></label>
                                        <table style="width:99%;" class="claimhistorydata">
                                            <thead>
                                                <th style="width: 10%;"><label class="titles">Year</label></th>
                                                @if (@$claimHistoryitem['type_col'])
                                                    <th style="width:{{@$item['columnWidth']?:'40px'}}"><label class="titles">Type</label></th>
                                                @endif
                                                @foreach (@$claimHistoryitem['columns']['onlyFirePerils'] as $item)
                                                    <th style="width:{{@$item['columnWidth']?:'40px'}}"><label class="titles">{{$item['label']}}</label></th>
                                                @endforeach
                                            </thead>
                                            <tbody>
                                                @foreach($formValues['eQuestionnaire']['policyDetails']['claimsHistory'] as $k=> $claimHistory)
                                                    @if(is_array($claimHistory))
                                                        <tr>
                                                            <td>{{$k}} &nbsp
                                                            @if($loop->iteration == 2)
                                                                (Most Recent)
                                                            @endif
                                                            </td>
                                                            @if (@$claimHistoryitem['type_col'])
                                                                <td>{{@$claimHistory['type']?:'--'}}</td>
                                                            @endif
                                                            @foreach ($claimHistoryitem['columns']['onlyFirePerils'] as $item1)
                                                                <td><p>{{@$claimHistory[$item1['fieldname']]?:'--'}}</p></td>
                                                            @endforeach
                                                        </tr>
                                                    @endif
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @endif
                            @endif
                            {{-- @widget('claimHistoryMultipleView',['data'=> $claimHistoryitem,'formValues'=>$formValues]) --}}
                        @endforeach
                    @endif
                </div>
            @endif
        </div>

        <div class="mycontainer" >
            <div class="table-responsive">
                <div class="table-responsive">
                    <table width="95%" style="margin-top: 30px"id="ecomptable" class=" comparison table table-bordered" cellpadding="0" cellspacing="0">
                        <thead >
                            <tr id="heading-row-qns">
                                <th class="mainsquestion" style="text-align: left;"><label style="font-size: 12px !important" class="titles blue">Clauses/Extensions</label></th>
                                <th class="mainsquestion" style="text-align: left;"><label style="font-size: 12px !important" class="titles blue">Customer Requirement</label></th>
                            </tr>
                        </thead>
                        <tbody >
                            @if($data['eSlipData'])
                                @foreach(@$data['eSlipData']['review'] as $review)
                                    @if($review['type'] == 'checkbox')
                                        <tr>
                                            <td class="mainsquestion">
                                                <label class="titles">
                                                    @if (isset($review['preCustomerLabel']) && @$review['preCustomerLabel'] != '')
                                                        {{htmlentities(@$review['preCustomerLabel'])}}
                                                    @else
                                                        {{htmlentities(@$review['label'])}}
                                                    @endif
                                                </label>
                                            </td>
                                            @if($review['type'] == 'checkbox')
                                                <td class="mainsanswer"><div class="ans">Required</div></td>
                                            @else
                                                <td class="mainsanswer">
                                                    <div class="ans">
                                                        @if (@$review['value'])
                                                            {{@$review['value']}}
                                                        @else
                                                            --
                                                        @endif
                                                    </div>
                                                </td>
                                            @endif
                                        </tr>
                                    @endif
                                @endforeach
                                @foreach(@$data['eSlipData']['forms'] as $forms)
                                    <?php
                                    // @$formsLabel = preg_replace('/\s/', '', @$forms['label']);
                                    // && (strtolower(htmlentities(@$formsLabel)) != 'premiumpaymentwarranty') &&(strtolower(htmlentities(@$formsLabel)) != 'warranty')
                                    //&& (strtolower(htmlentities(@$formsLabel))!= 'exclusion') && (strtolower(htmlentities(@$formsLabel)) != 'specialcondition')
                                     ?>

                                    @if ((isset($forms['quotationPdfViewStatus']) && $forms['quotationPdfViewStatus'] ))
                                    <tr>
                                        <td class="mainsquestion">
                                            <label class="titles">
                                                @if (isset($forms['preCustomerLabel']) && @$forms['preCustomerLabel'] != '')
                                                    {{htmlentities(@$forms['preCustomerLabel'])}}
                                                @else
                                                    {{htmlentities(@$forms['label'])}}
                                                @endif
                                            </label>
                                        </td>
                                        @if(is_array(@$forms['value']))
                                            @if(@$forms['fieldName'] == 'CombinedOrSeperatedRate')
                                                <td class="mainsanswer">
                                                    <div class="ans">
                                                        @if(@$forms['value']['seperateStatus'] == 'seperate')
                                                            Admin Rate : {{@$forms['value']['adminRate']}}
                                                            Non-Admin Rate : {{@$forms['value']['nonAdminRate']}}
                                                        @else
                                                            Combined Rate : {{@$forms['value']['combinedRate']}}
                                                            @if (@$forms['value']['Premium'])
                                                            <br>Premium :  {{@$forms['value']['Premium']}}
                                                            @endif
                                                        @endif
                                                    </div>
                                                </td>
                                            @else
                                                <td class="mainsanswer">
                                                    <div class="ans">
                                                        @if (isset($forms['value']['isChecked']) && @$forms['value']['isChecked'] == 'yes')
                                                        Required
                                                        @else
                                                            <?php
                                                                if (gettype(@$forms['value']) == 'array' && !empty(@$forms['value'])) {
                                                                    $indexArray =array_values($forms['value']);
                                                                    if (strtolower(@$indexArray[0]) == 'yes') {
                                                                        ?>
                                                                        Required
                                                                        <?php
                                                                    } else {
                                                                        ?>
                                                                        --
                                                                        <?php
                                                                    }
                                                                } else {
                                                                    ?>
                                                                        --
                                                                    <?php
                                                                }
                                                            ?>
                                                        @endif
                                                    </div>
                                                </td>
                                            @endif
                                        @else
                                            <td class="mainsanswer">
                                                <div class="ans">
                                                        @if (@$forms['value'])
                                                            {{@$forms['value']}}
                                                        @else
                                                        --
                                                        @endif
                                                </div>
                                            </td>
                                        @endif
                                    </tr>
                                    @endif
                                @endforeach
                            @endif
                        </tbody>
                    </table>
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
    line-height: 100%;
   
}
table{
    border-collapse: collapse;
    border: 1px solid #dee2e6;
    margin-bottom: 10px;
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
    max-width: 99%;
}
.titles span{
    color: #000;
}
.pdf_header{
    width: 99%;
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
/* tr  h6  { page-break-inside:avoid  !important; page-break-after:auto  !important;overflow: visible !important; } */
</style>

<!-- jQuery -->
<script  src="{{ URL::asset('widgetStyle/js/main/jquery-2.2.4.min.js')}}"></script>
<script>
    $('.removeTr').parent().parent().remove();
</script>

</body>
</html>
