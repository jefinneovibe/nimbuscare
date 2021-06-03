@extends('layouts.widget_layout')
@section('content')
<style>
.titles{
      width: 80%;
}
</style>

    <div class="row eslipscroll">
        <!------------ review col-8 start-->
        <div class="col-8 eslip_leftscroll">
            <div class="container-fluid">
            <table class="borderless_table">
                <?php
                    $covers = [];
                    $esipArray= [];
                    $esipPrePostTable= [];
                    $eslipFormMuliplier= [];
                    $sitCheckboxArr=[];
                    $multiDocumentArr=[];
                    $multiCheckBoxArr=[];
                    $eslipBasicTableArr=[];
                    $claimHistoryView=[];
                    $EslipClaimHistory=[];
                ?>
                
                @foreach ($reviewData['fields'] as $field)
                
                    @if(@$field['eQuotationVisibility'])
                        <?php $reviewArr[] = $field; ?>
                    @elseif (@$field['type'] == 'LocationSum')
                        <?php $reviewArr[] = $field;   ?>
                    @endif
                    @if (isset($field['isLocationRelated']) && $field['isLocationRelated'])
                        <?php @eval("\$viewItm = \"{$field['locationCheckValue']}\";"); ?>
                        @if (in_array($viewItm, $field['locationMatchValue']))
                            @if ($field['type'] == 'text')
                                @if (isset($field['isBusinessRelated']) && $field['isBusinessRelated'])
                                    @if (count($field['relatedBusiness']) > 0)
                                        @if (in_array (@$formValues['eQuestionnaire']['businessDetails']['businessType']['optionId'], $field['relatedBusiness']))
                                            <tr class="form-group">
                                                <td class="qus_title"><label><b class="titles">{{$field['label']}}</b></label></td>
                                                @if($field['label'])<td class="colon">:</td> @else <td class="colon"></td> @endif
                                                <?php @eval("\$str = \"{$field['value']}\";"); ?>
                                                <td><label class="titles">{{@$str}}</label>
                                                    @if(!empty($field['statement']))
                                                        <div class="disclaimer red spacing">
                                                            <p class="text-justify">{{$field['statement']}}</p>
                                                        </div>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endif
                                    @endif
                                @elseif (isset($field['isWidgetRelated']) && $field['isWidgetRelated'] === True)
                                   <?php @eval("\$str123_field = \"{$field['checkValue']}\";");?>
                                    @if (in_array (@$str123_field, $field['matchValue']))
                                        <tr class="form-group">
                                            <td class="qus_title"><label><b class="titles">{{$field['label']}}</b></label></td>
                                            @if($field['label'])
                                                <td class="colon">:</td>
                                            @else
                                                <td class="colon"></td>
                                            @endif
                                            <?php @eval("\$str = \"{$field['value']}\";"); ?>
                                            <td>
                                                <label class="titles">{{@$str}}</label>
                                                @if(!empty($field['statement']))
                                                    <div class="disclaimer red spacing">
                                                        <p class="text-justify">{{$field['statement']}}</p>
                                                    </div>
                                                @endif
                                            </td>
                                        </tr>
                                    @endif
                                @else
                                    <tr class="form-group">
                                        <td class="qus_title"><label><b class="titles">{{$field['label']}}</b></label></td>
                                        @if($field['label'])<td class="colon">:</td> @else <td class="colon"></td> @endif
                                        <?php @eval("\$str = \"{$field['value']}\";"); ?>
                                        @if(isset($field['sum']) && $field['sum'] == true)
                                            <?php
                                                $finalArray=array_map(function($value){
                                                return str_replace(',', '', $value);
                                                },explode('|', $str));
                                                $sum = array_sum($finalArray);
                                                $str = number_format($sum);

                                            ?>
                                        @endif
                                        <td>
                                            @if (@$field['fieldName'] == 'geographicalArea')
                                                @if (@$formValues['eQuestionnaire']['businessDetails']['placeOfEmployment']['withinUAE'] == 'Within UAE')
                                                    <label class="titles">Within UAE</label>
                                                @else
                                                    <label class="titles">{{@$formValues['eQuestionnaire']['businessDetails']['placeOfEmployment']['countryName']}}</label>
                                                @endif
                                            @else
                                            @if($str)
                                                <label class="titles">{{@$str}}</label>
                                                @else
                                                <label class="titles">NA</label>
                                                @endif
                                            @endif
                                            @if(!empty($field['statement']))
                                                <div class="disclaimer red spacing">
                                                    <p class="text-justify">{{$field['statement']}}</p>
                                                </div>
                                            @endif
                                        </td>
                                    </tr>
                                @endif
                            @elseif ($field['type'] == 'AnnualWages')
                                @if (isset($field['isBusinessRelated']) && $field['isBusinessRelated'])
                                    @if (count($field['relatedBusiness']) > 0)
                                        @if (in_array (@$formValues['eQuestionnaire']['businessDetails']['businessType']['optionId'], $field['relatedBusiness']))
                                            @widget('annual_wages',['data'=> $field,'formValues'=>$formValues])
                                        @endif
                                    @endif
                                @elseif (isset($field['isWidgetRelated']) && $field['isWidgetRelated'] === True)
                                    <?php @eval("\$str123_field = \"{$field['checkValue']}\";");?>
                                    @if (in_array (@$str123_field, $field['matchValue']))
                                        @widget('annual_wages',['data'=> $field,'formValues'=>$formValues])
                                    @endif
                                @else
                                    @widget('annual_wages',['data'=> $field,'formValues'=>$formValues])
                                @endif
                            @elseif ($field['type'] == 'EslipMultiDocumentView')
                                @if (isset($field['isBusinessRelated']) && $field['isBusinessRelated'])
                                    @if (count($field['relatedBusiness']) > 0)
                                        @if (in_array (@$formValues['eQuestionnaire']['businessDetails']['businessType']['optionId'], $field['relatedBusiness']))
                                            <?php $multiDocumentArr[]=$field; ?>
                                        @endif
                                    @endif
                                @elseif (isset($field['isWidgetRelated']) && $field['isWidgetRelated'] === True)
                                    <?php @eval("\$str123_field = \"{$field['checkValue']}\";");?>
                                    @if (in_array (@$str123_field, $field['matchValue']))
                                        <?php $multiDocumentArr[]=$field; ?>
                                    @endif
                                @else
                                    <?php $multiDocumentArr[]=$field; ?>
                                @endif
                            @elseif ($field['type'] == 'EslipPrePostTable')
                                <?php $esipPrePostTable[] =$field;  ?>
                            @elseif ($field['type'] == 'EslipMultiCheckbox')
                                <?php  $multiCheckBoxArr[] = $field; ?>
                            @elseif ($field['type'] == 'claimHistoryView')
                                <?php $claim = 1;  $EslipClaimHistory[] = $field; ?>
                            @elseif ($field['type'] == 'claimHistoryMultipleView')
                                <?php $claimMultiple = 1;  $claimHistoryView[] = $field;  ?>
                            @elseif($field['type'] == 'checkbox')
                                @if (isset($field['isBusinessRelated']) && $field['isBusinessRelated'])
                                    @if (count($field['relatedBusiness']) > 0)
                                        @if (in_array (@$formValues['eQuestionnaire']['businessDetails']['businessType']['optionId'], $field['relatedBusiness']))
                                            <?php $sitCheckboxArr[] = $field; ?>
                                        @endif
                                    @endif
                                @elseif (isset($field['isWidgetRelated']) && $field['isWidgetRelated'] === True)
                                    <?php @eval("\$str123 = \"{$field['checkValue']}\";"); ?>
                                    @if (count($str123) > 0)
                                        @if (isset($field['isLimitCheck']) && $field['isLimitCheck'] === True)
                                            @if (isset($field['lowerLimit']) && isset($field['upperLimit']))
                                                @if ( ($field['lowerLimit'] < $str123) && ($str123 < $field['upperLimit']))
                                                    <?php $sitCheckboxArr[] = $field; ?>
                                                @endif
                                            @elseif(isset($field['lowerLimit']))
                                                @if ( ($field['lowerLimit'] < $str123))
                                                    <?php $sitCheckboxArr[] = $field; ?>
                                                @endif
                                            @else
                                                @if (($str123 < $field['upperLimit']))
                                                    <?php $sitCheckboxArr[] = $field; ?>
                                                @endif
                                            @endif
                                        @else
                                            @if (in_array (@$str123, $field['matchValue']))
                                                @if(isset($field['isChecked']))
                                                    <?php $sitCheckboxArr[] = $field; ?>
                                                @endif
                                            @endif
                                        @endif
                                    @endif
                                @else
                                    @if (@$field['label'])
                                        <?php $checkboxArr[] = $field; ?>
                                    @endif
                                @endif

                            @elseif($field['type'] == 'widget')
                                <?php $widgetArr[] = $field; ?>
                            @elseif($field['type'] == 'EslipArrayView')
                                <?php $esipArray[] = $field; ?>
                                @elseif($field['type'] == 'EslipFormMultiplier')
                                <?php $eslipFormMuliplier[] = $field; ?>
                                {{-- @widget('EslipArrayView',['data'=> $field,'formValues'=>$formValues]) --}}
                            @elseif ($field['type'] == 'cover')
                                <?php $covers[] = $field; ?>
                            @elseif ($field['type'] == 'EslipBasicTable')
                                    <?php $eslipBasicTableArr[] = $field; ?>
                            @elseif ($field['type'] == 'Subeightt')
                                    <?php $subeighttArr[] = $field; ?>
                            @endif
                        @endif
                    @else
                        @if ($field['type'] == 'text')
                            @if (isset($field['isBusinessRelated']) && $field['isBusinessRelated'])
                                @if (count($field['relatedBusiness']) > 0)
                                    @if (in_array (@$formValues['eQuestionnaire']['businessDetails']['businessType']['optionId'], $field['relatedBusiness']))
                                        <tr class="form-group">
                                            <td class="qus_title"><label><b class="titles">{{$field['label']}}</b></label></td>
                                            @if($field['label'])<td class="colon">:</td> @else <td class="colon"></td> @endif
                                            <?php @eval("\$str = \"{$field['value']}\";"); ?>
                                            <td><label class="titles">{{@$str}}</label>
                                                @if(!empty($field['statement']))
                                                    <div class="disclaimer red spacing">
                                                        <p class="text-justify">{{$field['statement']}}</p>
                                                    </div>
                                                @endif
                                            </td>
                                        </tr>
                                    @endif
                                @endif
                            @elseif (isset($field['isWidgetRelated']) && $field['isWidgetRelated'] === True)
                                <?php @eval("\$str123_field = \"{$field['checkValue']}\";");?>
                                @if (in_array (@$str123_field, $field['matchValue']))
                                    <tr class="form-group">
                                        <td class="qus_title"><label><b class="titles">{{$field['label']}}</b></label></td>
                                        @if($field['label'])
                                            <td class="colon">:</td>
                                        @else
                                            <td class="colon"></td>
                                        @endif
                                        <?php @eval("\$str = \"{$field['value']}\";"); ?>
                                        <td>
                                            <label class="titles">{{@$str}}</label>
                                            @if(!empty($field['statement']))
                                                <div class="disclaimer red spacing">
                                                    <p class="text-justify">{{$field['statement']}}</p>
                                                </div>
                                            @endif
                                        </td>
                                    </tr>
                                @endif
                            @else
                                <tr class="form-group">
                                    <td class="qus_title"><label><b class="titles">{{$field['label']}}</b></label></td>
                                    @if($field['label'])<td class="colon">:</td> @else <td class="colon"></td> @endif
                                    <?php @eval("\$str = \"{$field['value']}\";"); ?>
                                    @if(isset($field['sum']) && $field['sum'] == true)
                                        <?php
                                            $finalArray=array_map(function($value){
                                            return str_replace(',', '', $value);
                                            },explode('|', $str));
                                            $sum = array_sum($finalArray);
                                            $str = number_format($sum);

                                        ?>
                                    @endif
                                    <td>
                                        @if (@$field['fieldName'] == 'geographicalArea')
                                            @if (@$formValues['eQuestionnaire']['businessDetails']['placeOfEmployment']['withinUAE'] == 'Within UAE')
                                                <label class="titles">Within UAE</label>
                                            @else
                                                <label class="titles">{{@$formValues['eQuestionnaire']['businessDetails']['placeOfEmployment']['countryName']}}</label>
                                            @endif
                                        @else
                                        @if($str)
                                            <label class="titles">{{@$str}}</label>
                                            @else
                                            <label class="titles">NA</label>
                                            @endif
                                        @endif
                                        @if(!empty($field['statement']))
                                            <div class="disclaimer red spacing">
                                                <p class="text-justify">{{$field['statement']}}</p>
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                            @endif
                        @elseif ($field['type'] == 'AnnualWages')
                            @if (isset($field['isBusinessRelated']) && $field['isBusinessRelated'])
                                @if (count($field['relatedBusiness']) > 0)
                                    @if (in_array (@$formValues['eQuestionnaire']['businessDetails']['businessType']['optionId'], $field['relatedBusiness']))
                                        @widget('annual_wages',['data'=> $field,'formValues'=>$formValues])
                                    @endif
                                @endif
                            @elseif (isset($field['isWidgetRelated']) && $field['isWidgetRelated'] === True)
                                <?php @eval("\$str123_field = \"{$field['checkValue']}\";");?>
                                @if (in_array (@$str123_field, $field['matchValue']))
                                    @widget('annual_wages',['data'=> $field,'formValues'=>$formValues])
                                @endif
                            @else
                                @widget('annual_wages',['data'=> $field,'formValues'=>$formValues])
                            @endif
                        @elseif ($field['type'] == 'EslipMultiDocumentView')
                            @if (isset($field['isBusinessRelated']) && $field['isBusinessRelated'])
                                @if (count($field['relatedBusiness']) > 0)
                                    @if (in_array (@$formValues['eQuestionnaire']['businessDetails']['businessType']['optionId'], $field['relatedBusiness']))
                                        <?php $multiDocumentArr[]=$field; ?>
                                    @endif
                                @endif
                            @elseif (isset($field['isWidgetRelated']) && $field['isWidgetRelated'] === True)
                                <?php @eval("\$str123_field = \"{$field['checkValue']}\";");?>
                                @if (in_array (@$str123_field, $field['matchValue']))
                                    <?php $multiDocumentArr[]=$field; ?>
                                @endif
                            @else
                                <?php $multiDocumentArr[]=$field; ?>
                            @endif
                        @elseif ($field['type'] == 'EslipPrePostTable')
                            <?php $esipPrePostTable[] =$field;  ?>
                        @elseif ($field['type'] == 'claimHistoryView')
                            <?php $claim = 1; $EslipClaimHistory[] = $field;?>
                        @elseif ($field['type'] == 'claimHistoryMultipleView')
                            <?php $claimMultiple = 1;  $claimHistoryView[] = $field;?>
                        @elseif($field['type'] == 'checkbox')
                            @if (isset($field['isBusinessRelated']) && $field['isBusinessRelated'])
                                @if (count($field['relatedBusiness']) > 0)
                                    @if (in_array (@$formValues['eQuestionnaire']['businessDetails']['businessType']['optionId'], $field['relatedBusiness']))
                                        <?php $sitCheckboxArr[] = $field; ?>
                                    @endif
                                @endif
                            @elseif (isset($field['isWidgetRelated']) && $field['isWidgetRelated'] === True)
                                <?php @eval("\$str123 = \"{$field['checkValue']}\";"); ?>
                                @if (count($str123) > 0)
                                    @if (isset($field['isLimitCheck']) && $field['isLimitCheck'] === True)
                                        @if (isset($field['lowerLimit']) && isset($field['upperLimit']))
                                            @if ( ($field['lowerLimit'] < $str123) && ($str123 < $field['upperLimit']))
                                                <?php $sitCheckboxArr[] = $field; ?>
                                            @endif
                                        @elseif(isset($field['lowerLimit']))
                                            @if ( ($field['lowerLimit'] < $str123))
                                                <?php $sitCheckboxArr[] = $field; ?>
                                            @endif
                                        @else
                                            @if (($str123 < $field['upperLimit']))
                                                <?php $sitCheckboxArr[] = $field; ?>
                                            @endif
                                        @endif
                                    @else
                                        @if (in_array (@$str123, $field['matchValue']))
                                            @if(isset($field['isChecked']))
                                                <?php $sitCheckboxArr[] = $field; ?>
                                            @endif
                                        @endif
                                    @endif
                                @endif
                            @else
                                @if (@$field['label'])
                                    <?php $checkboxArr[] = $field; ?>
                                @endif
                            @endif

                        @elseif($field['type'] == 'widget')
                            <?php $widgetArr[] = $field; ?>
                        @elseif($field['type'] == 'EslipArrayView')
                            <?php $esipArray[] = $field; ?>
                            @elseif($field['type'] == 'EslipFormMultiplier')
                                @if(isset($field['isWidgetRelated']) && @$field["isWidgetRelated"]==true)
                                    <?php @eval("\$str123_field = \"{$field['checkValue']}\";");?>
                                    @if (in_array (@$str123_field, @$field['matchValue']))                            
                                        <?php $eslipFormMuliplier[] = $field; ?>
                                    @endif
                                @else
                                    <?php $eslipFormMuliplier[] = $field; ?>
                                @endif
                            {{-- @widget('EslipArrayView',['data'=> $field,'formValues'=>$formValues]) --}}
                        @elseif ($field['type'] == 'cover')
                            <?php $covers[] = $field; ?>
                        @elseif ($field['type'] == 'EslipMultiCheckbox')
                            <?php  $multiCheckBoxArr[] = $field; ?>
                        @elseif ($field['type'] == 'EslipBasicTable')
                                <?php $eslipBasicTableArr[] = $field; ?>
                        @elseif ($field['type'] == 'Subeightt')                        
                                <?php $subeighttArr[] = $field; ?>                                
                        @endif
                    @endif
                @endforeach
            </table>
            @if (!empty($multiCheckBoxArr))
                @foreach ($multiCheckBoxArr as $multiCheckbox)
                    @widget('EslipMultiCheckbox',['data'=> $multiCheckbox,'formValues'=>$formValues])
                @endforeach
            @endif
            @if (!empty($eslipFormMuliplier))
                @foreach ($eslipFormMuliplier as $eachform)
                    @widget('EslipFormMultiplier',['data'=> $eachform,'formValues'=>$formValues])
                @endforeach
            @endif
            @if (!empty($esipPrePostTable))
                @foreach ($esipPrePostTable as $eachPrePost)
                    @widget('EslipPrePostTable',['data'=> $eachPrePost,'formValues'=>$formValues])
                @endforeach
            @endif
            @if (!empty($esipArray))
                @foreach ($esipArray as $field)
                    @if($field['type'] == 'EslipArrayView')
                        @widget('EslipArrayView',['data'=> $field,'formValues'=>$formValues])
                    @endif
                @endforeach
            @endif
            @if (!empty($reviewData))
                @foreach ($reviewData['fields'] as $field)
                    @if($field['type'] == 'table')
                        @widget('Table',['data'=> $field,'formValues'=>$formValues])
                    @endif
                @endforeach
            @endif
            @if (!empty($eslipBasicTableArr))
                @foreach ($eslipBasicTableArr as $eslipBasicTable)
                    @if($eslipBasicTable['type'] == 'EslipBasicTable')
                        @widget('EslipBasicTable',['data'=> $eslipBasicTable,'formValues'=>$formValues])
                    @endif
                @endforeach
            @endif
            @if (!empty($covers))
                @foreach ($covers as $cover)
                    @widget('cover',['data'=> $cover])
                @endforeach
            @endif
            @if (!empty($multiDocumentArr))
                @foreach ($multiDocumentArr as $multiDocument)
                    @widget('eslip_multi_document_view',['data'=> $multiDocument,'formValues'=>$formValues])
                @endforeach
            @endif
            <?php
                function arraySortForLabels($array)
                {
                    $new_array = array();
                    $sortable_array = array();
                    $i = 0;
                    if (count($array) > 0) {
                        foreach ($array as $k => $v) {
                            if (is_array($v)) {
                                foreach ($v as $k2 => $v2) {
                                    if ($k2 == "label") {
                                        $sortable_array[$k] = $v2;
                                    }
                                }
                            } else {
                                $sortable_array[$k] = $v;
                            }
                        }
                        asort($sortable_array);
                        foreach ($sortable_array as $k => $v) {
                            $new_array[$i] = $array[$k];
                            $i++;
                        }
                    }
                    return  $new_array;
                }
            ?>

                @if(!empty(@$checkboxArr))
                    <?php
                        $checkboxArr = arraySortForLabels($checkboxArr);
                        // $checkboxArr = array_reverse($checkboxArr);
                        // if (count($checkboxArr)>1) {
                        //     $checkboxArr = array_chunk($checkboxArr, count($checkboxArr)/2);
                        // } elseif (count($checkboxArr) == 1) {
                        //     $checkboxArr =array_chunk($checkboxArr, 1);
                        // } dd($checkboxArr);
                    ?>
                    <br>
                    <div class="row">
                        {{-- @foreach($checkboxArr as $k => $each) --}}
                            @foreach($checkboxArr as $key => $checkbox)
                                @if (isset($checkbox['isLocationRelated']) && $checkbox['isLocationRelated'])
                                    <?php @eval("\$viewItm = \"{$checkbox['locationCheckValue']}\";"); ?>
                                    @if (in_array($viewItm, $checkbox['locationMatchValue']))
                                        @if (isset($checkbox['isBusinessRelated']) && $checkbox['isBusinessRelated'])
                                            @if (count($checkbox['relatedBusiness']) > 0)
                                                @if (in_array (@$formValues['eQuestionnaire']['businessDetails']['businessType']['optionId'], $checkbox['relatedBusiness']))
                                                    <div class="custom-control custom-checkbox mb-3 col-6">
                                                        @if ($checkbox['isChecked'])
                                                            <input class="custom-control-input" id="{{$key}}" type="checkbox" checked disabled>
                                                        @endif
                                                        <label class="custom-control-label " for="{{$key}}">{{$checkbox['label']}}</label>
                                                    </div>
                                                @endif
                                            @endif
                                        @elseif (isset($checkbox['isWidgetRelated']) && $checkbox['isWidgetRelated'] === True)
                                            <?php @eval("\$str123 = \"{$checkbox['checkValue']}\";"); ?>
                                            @if (count($str123) > 0)
                                                @if (isset($checkbox['isLimitCheck']) && $checkbox['isLimitCheck'] === True)
                                                    @if (isset($checkbox['lowerLimit']) && isset($checkbox['upperLimit']))
                                                        @if ( ($checkbox['lowerLimit'] < $str123) && ($str123 < $checkbox['upperLimit']))
                                                            <div class="custom-control custom-checkbox mb-3 col-6">
                                                                @if (@isset($checkbox['isChecked']))
                                                                    @if ($checkbox['isChecked'])
                                                                        <input class="custom-control-input" id="{{$key}}" type="checkbox" checked disabled>
                                                                    @endif
                                                                @endif
                                                            <label class="custom-control-label " for="{{$key}}">{{$checkbox['label']}}</label>
                                                            </div>
                                                        @endif
                                                    @elseif(isset($checkbox['lowerLimit']))
                                                        @if ( ($checkbox['lowerLimit'] < $str123))
                                                        <div class="custom-control custom-checkbox mb-3 col-6">
                                                            @if (@isset($checkbox['isChecked']))
                                                                @if ($checkbox['isChecked'])
                                                                    <input class="custom-control-input" id="{{$key}}" type="checkbox" checked disabled>
                                                                @endif
                                                            @endif
                                                            <label class="custom-control-label " for="{{$key}}">{{$checkbox['label']}}</label>
                                                        </div>
                                                        @endif
                                                    @else
                                                        @if (($str123 < $checkbox['upperLimit']))
                                                        <div class="custom-control custom-checkbox mb-3 col-6">
                                                            @if (@isset($checkbox['isChecked']))
                                                                @if ($checkbox['isChecked'])
                                                                    <input class="custom-control-input" id="{{$key}}" type="checkbox" checked disabled>
                                                                @endif
                                                            @endif
                                                            <label class="custom-control-label " for="{{$key}}">{{$checkbox['label']}}</label>
                                                        </div>
                                                        @endif
                                                    @endif
                                                @else
                                                    @if (in_array (@$str123, $checkbox['matchValue']))
                                                    @if(isset($checkbox['isChecked']))
                                                        <div class="custom-control custom-checkbox mb-3 col-6">
                                                            @if (@isset($checkbox['isChecked']))
                                                                @if ($checkbox['isChecked'])
                                                                    <input class="custom-control-input" id="{{$key}}" type="checkbox" checked disabled>
                                                                @endif
                                                            @endif
                                                            <label class="custom-control-label " for="{{$key}}">{{$checkbox['label']}}</label>
                                                        </div>
                                                    @endif
                                                    @endif
                                                @endif
                                            @endif
                                        @else
                                            @if (@$checkbox['label'])
                                                <div class="custom-control custom-checkbox mb-3 col-6">
                                                    @if (@isset($checkbox['isChecked']))
                                                        @if ($checkbox['isChecked'])
                                                        <input class="custom-control-input" id="{{$key}}" type="checkbox" checked disabled>
                                                        @endif
                                                    @else
                                                        <input class="custom-control-input" id="{{$key}}" type="checkbox" checked disabled>
                                                    @endif
                                                    <label class="custom-control-label " for="{{$key}}">{{$checkbox['label']}}</label>
                                                </div>
                                            @endif
                                        @endif
                                    @endif
                                @else
                                    @if (isset($checkbox['isBusinessRelated']) && $checkbox['isBusinessRelated'])
                                        @if (count($checkbox['relatedBusiness']) > 0)
                                            @if (in_array (@$formValues['eQuestionnaire']['businessDetails']['businessType']['optionId'], $checkbox['relatedBusiness']))
                                                <div class="custom-control custom-checkbox mb-3 col-6">
                                                    @if ($checkbox['isChecked'])
                                                        <input class="custom-control-input" id="{{$key}}" type="checkbox" checked disabled>
                                                    @endif
                                                    <label class="custom-control-label " for="{{$key}}">{{$checkbox['label']}}</label>
                                                </div>
                                            @endif
                                        @endif
                                    @elseif (isset($checkbox['isWidgetRelated']) && $checkbox['isWidgetRelated'] === True)
                                        <?php @eval("\$str123 = \"{$checkbox['checkValue']}\";"); ?>
                                        @if (count($str123) > 0)
                                            @if (isset($checkbox['isLimitCheck']) && $checkbox['isLimitCheck'] === True)
                                                @if (isset($checkbox['lowerLimit']) && isset($checkbox['upperLimit']))
                                                    @if ( ($checkbox['lowerLimit'] < $str123) && ($str123 < $checkbox['upperLimit']))
                                                        <div class="custom-control custom-checkbox mb-3 col-6">
                                                            @if (@isset($checkbox['isChecked']))
                                                                @if ($checkbox['isChecked'])
                                                                    <input class="custom-control-input" id="{{$key}}" type="checkbox" checked disabled>
                                                                @endif
                                                            @endif
                                                        <label class="custom-control-label " for="{{$key}}">{{$checkbox['label']}}</label>
                                                        </div>
                                                    @endif
                                                @elseif(isset($checkbox['lowerLimit']))
                                                    @if ( ($checkbox['lowerLimit'] < $str123))
                                                    <div class="custom-control custom-checkbox mb-3 col-6">
                                                        @if (@isset($checkbox['isChecked']))
                                                            @if ($checkbox['isChecked'])
                                                                <input class="custom-control-input" id="{{$key}}" type="checkbox" checked disabled>
                                                            @endif
                                                        @endif
                                                        <label class="custom-control-label " for="{{$key}}">{{$checkbox['label']}}</label>
                                                    </div>
                                                    @endif
                                                @else
                                                    @if (($str123 < $checkbox['upperLimit']))
                                                    <div class="custom-control custom-checkbox mb-3 col-6">
                                                        @if (@isset($checkbox['isChecked']))
                                                            @if ($checkbox['isChecked'])
                                                                <input class="custom-control-input" id="{{$key}}" type="checkbox" checked disabled>
                                                            @endif
                                                        @endif
                                                        <label class="custom-control-label " for="{{$key}}">{{$checkbox['label']}}</label>
                                                    </div>
                                                    @endif
                                                @endif
                                            @else
                                                @if (in_array (@$str123, $checkbox['matchValue']))
                                                @if(isset($checkbox['isChecked']))
                                                    <div class="custom-control custom-checkbox mb-3 col-6">
                                                        @if (@isset($checkbox['isChecked']))
                                                            @if ($checkbox['isChecked'])
                                                                <input class="custom-control-input" id="{{$key}}" type="checkbox" checked disabled>
                                                            @endif
                                                        @endif
                                                        <label class="custom-control-label " for="{{$key}}">{{$checkbox['label']}}</label>
                                                    </div>
                                                @endif
                                                @endif
                                            @endif
                                        @endif
                                    @else
                                        @if (@$checkbox['label'])
                                            <div class="custom-control custom-checkbox mb-3 col-6">
                                                @if (@isset($checkbox['isChecked']))
                                                    @if ($checkbox['isChecked'])
                                                    <input class="custom-control-input" id="{{$key}}" type="checkbox" checked disabled>
                                                    @endif
                                                @else
                                                    <input class="custom-control-input" id="{{$key}}" type="checkbox" checked disabled>
                                                @endif
                                                <label class="custom-control-label " for="{{$key}}">{{$checkbox['label']}}</label>
                                            </div>
                                        @endif
                                    @endif
                                @endif
                            @endforeach
                        {{-- @endforeach --}}
                    </div>
                @endif



            @if (!empty($sitCheckboxArr))
            <?php  $sitCheckboxArr = arraySortForLabels($sitCheckboxArr); ?>
                <hr class="eslipHr">
                <div class="row">
                    @foreach($sitCheckboxArr as $keySit => $checkboxSit)
                        @if (isset($checkboxSit['isLocationRelated']) && $checkboxSit['isLocationRelated'])
                            <?php @eval("\$viewItm = \"{$checkboxSit['locationCheckValue']}\";"); ?>
                            @if (in_array($viewItm, $checkboxSit['locationMatchValue']))
                                @if (isset($checkboxSit['isBusinessRelated']) && $checkboxSit['isBusinessRelated'])
                                    @if (count($checkboxSit['relatedBusiness']) > 0)
                                        @if (in_array (@$formValues['eQuestionnaire']['businessDetails']['businessType']['optionId'], $checkboxSit['relatedBusiness']))
                                            <div class="custom-control custom-checkbox mb-3 col-6">
                                                @if ($checkboxSit['isChecked'])
                                                    <input class="custom-control-input" id="{{$keySit}}" type="checkbox" checked disabled>
                                                @endif
                                                <label class="custom-control-label " for="{{$keySit}}">{{$checkboxSit['label']}}</label>
                                            </div>
                                        @endif
                                    @endif
                                @elseif (isset($checkboxSit['isWidgetRelated']) && $checkboxSit['isWidgetRelated'] === True)
                                    <?php @eval("\$str123 = \"{$checkboxSit['checkValue']}\";"); ?>
                                    @if (count($str123) > 0)
                                        @if (isset($checkboxSit['isLimitCheck']) && $checkboxSit['isLimitCheck'] === True)
                                            @if (isset($checkboxSit['lowerLimit']) && isset($checkboxSit['upperLimit']))
                                                @if ( ($checkboxSit['lowerLimit'] < $str123) && ($str123 < $checkboxSit['upperLimit']))
                                                    <div class="custom-control custom-checkbox mb-3 col-6">
                                                        @if (@isset($checkboxSit['isChecked']))
                                                            @if ($checkboxSit['isChecked'])
                                                                <input class="custom-control-input" id="{{$keySit}}" type="checkbox" checked disabled>
                                                            @endif
                                                        @endif
                                                    <label class="custom-control-label " for="{{$keySit}}">{{$checkboxSit['label']}}</label>
                                                    </div>
                                                @endif
                                            @elseif(isset($checkboxSit['lowerLimit']))
                                                @if ( ($checkboxSit['lowerLimit'] < $str123))
                                                <div class="custom-control custom-checkbox mb-3 col-6">
                                                    @if (@isset($checkboxSit['isChecked']))
                                                        @if ($checkboxSit['isChecked'])
                                                            <input class="custom-control-input" id="{{$keySit}}" type="checkbox" checked disabled>
                                                        @endif
                                                    @endif
                                                    <label class="custom-control-label " for="{{$keySit}}">{{$checkboxSit['label']}}</label>
                                                </div>
                                                @endif
                                            @else
                                                @if (($str123 < $checkboxSit['upperLimit']))
                                                <div class="custom-control custom-checkbox mb-3 col-6">
                                                    @if (@isset($checkboxSit['isChecked']))
                                                        @if ($checkboxSit['isChecked'])
                                                            <input class="custom-control-input" id="{{$keySit}}" type="checkbox" checked disabled>
                                                        @endif
                                                    @endif
                                                    <label class="custom-control-label " for="{{$keySit}}">{{$checkboxSit['label']}}</label>
                                                </div>
                                                @endif
                                            @endif
                                        @else
                                            @if (in_array (@$str123, $checkboxSit['matchValue']))
                                                @if(isset($checkboxSit['isChecked']))
                                                    <div class="custom-control custom-checkbox mb-3 col-6">
                                                        @if (@isset($checkboxSit['isChecked']))
                                                            @if ($checkboxSit['isChecked'])
                                                                <input class="custom-control-input" id="{{$keySit}}" type="checkbox" checked disabled>
                                                            @endif
                                                        @endif
                                                        <label class="custom-control-label " for="{{$keySit}}">{{$checkboxSit['label']}}</label>
                                                    </div>
                                                @endif
                                            @endif
                                        @endif
                                    @endif
                                @else
                                    @if (@$checkboxSit['label'])
                                        <div class="custom-control custom-checkbox mb-3 col-6">
                                            @if (@isset($checkboxSit['isChecked']))
                                                @if ($checkboxSit['isChecked'])
                                                <input class="custom-control-input" id="{{$keySit}}" type="checkbox" checked disabled>
                                                @endif
                                            @else
                                                <input class="custom-control-input" id="{{$keySit}}" type="checkbox" checked disabled>
                                            @endif
                                            <label class="custom-control-label " for="{{$keySit}}">{{$checkboxSit['label']}}</label>
                                        </div>
                                    @endif
                                @endif
                            @endif
                        @else
                            @if (isset($checkboxSit['isBusinessRelated']) && $checkboxSit['isBusinessRelated'])
                                @if (count($checkboxSit['relatedBusiness']) > 0)
                                    @if (in_array (@$formValues['eQuestionnaire']['businessDetails']['businessType']['optionId'], $checkboxSit['relatedBusiness']))
                                        <div class="custom-control custom-checkbox mb-3 col-6">
                                            @if ($checkboxSit['isChecked'])
                                                <input class="custom-control-input" id="{{$keySit}}" type="checkbox" checked disabled>
                                            @endif
                                            <label class="custom-control-label " for="{{$keySit}}">{{$checkboxSit['label']}}</label>
                                        </div>
                                    @endif
                                @endif
                            @elseif (isset($checkboxSit['isWidgetRelated']) && $checkboxSit['isWidgetRelated'] === True)
                                <?php @eval("\$str123 = \"{$checkboxSit['checkValue']}\";"); ?>
                                @if (count($str123) > 0)
                                    @if (isset($checkboxSit['isLimitCheck']) && $checkboxSit['isLimitCheck'] === True)
                                        @if (isset($checkboxSit['lowerLimit']) && isset($checkboxSit['upperLimit']))
                                            @if ( ($checkboxSit['lowerLimit'] < $str123) && ($str123 < $checkboxSit['upperLimit']))
                                                <div class="custom-control custom-checkbox mb-3 col-6">
                                                    @if (@isset($checkboxSit['isChecked']))
                                                        @if ($checkboxSit['isChecked'])
                                                            <input class="custom-control-input" id="{{$keySit}}" type="checkbox" checked disabled>
                                                        @endif
                                                    @endif
                                                <label class="custom-control-label " for="{{$keySit}}">{{$checkboxSit['label']}}</label>
                                                </div>
                                            @endif
                                        @elseif(isset($checkboxSit['lowerLimit']))
                                            @if ( ($checkboxSit['lowerLimit'] < $str123))
                                            <div class="custom-control custom-checkbox mb-3 col-6">
                                                @if (@isset($checkboxSit['isChecked']))
                                                    @if ($checkboxSit['isChecked'])
                                                        <input class="custom-control-input" id="{{$keySit}}" type="checkbox" checked disabled>
                                                    @endif
                                                @endif
                                                <label class="custom-control-label " for="{{$keySit}}">{{$checkboxSit['label']}}</label>
                                            </div>
                                            @endif
                                        @else
                                            @if (($str123 < $checkboxSit['upperLimit']))
                                            <div class="custom-control custom-checkbox mb-3 col-6">
                                                @if (@isset($checkboxSit['isChecked']))
                                                    @if ($checkboxSit['isChecked'])
                                                        <input class="custom-control-input" id="{{$keySit}}" type="checkbox" checked disabled>
                                                    @endif
                                                @endif
                                                <label class="custom-control-label " for="{{$keySit}}">{{$checkboxSit['label']}}</label>
                                            </div>
                                            @endif
                                        @endif
                                    @else
                                        @if (in_array (@$str123, $checkboxSit['matchValue']))
                                            @if(isset($checkboxSit['isChecked']))
                                                <div class="custom-control custom-checkbox mb-3 col-6">
                                                    @if (@isset($checkboxSit['isChecked']))
                                                        @if ($checkboxSit['isChecked'])
                                                            <input class="custom-control-input" id="{{$keySit}}" type="checkbox" checked disabled>
                                                        @endif
                                                    @endif
                                                    <label class="custom-control-label " for="{{$keySit}}">{{$checkboxSit['label']}}</label>
                                                </div>
                                            @endif
                                        @endif
                                    @endif
                                @endif
                            @else
                                @if (@$checkboxSit['label'])
                                    <div class="custom-control custom-checkbox mb-3 col-6">
                                        @if (@isset($checkboxSit['isChecked']))
                                            @if ($checkboxSit['isChecked'])
                                            <input class="custom-control-input" id="{{$keySit}}" type="checkbox" checked disabled>
                                            @endif
                                        @else
                                            <input class="custom-control-input" id="{{$keySit}}" type="checkbox" checked disabled>
                                        @endif
                                        <label class="custom-control-label " for="{{$keySit}}">{{$checkboxSit['label']}}</label>
                                    </div>
                                @endif
                            @endif
                        @endif
                    @endforeach
                </div>
            @endif



                @if (@$claim == 1)
                @if (!empty($EslipClaimHistory))
                    @foreach ($EslipClaimHistory as $eachEslipClaimHistory)
                        @widget('EslipClaimHistory',['data'=> $eachEslipClaimHistory,'formValues'=>$formValues])
                    @endforeach
                @endif
                @elseif (@$claimMultiple == 1)
                    @if (!empty($claimHistoryView))
                        @foreach ($claimHistoryView as $eachclaimHistoryView)
                            @widget('claimHistoryMultipleView',['data'=> $eachclaimHistoryView,'formValues'=>$formValues])
                        @endforeach
                    @endif
                @else
                    @if(!empty($formValues['eQuestionnaire']['policyDetails']['claimsHistory']))
                        <div class="row">
                            <div class="col-12 form-group">
                            <label><b class="titles">Claim History</b></label>
                            </div>
                            <div class="col-12 form-group">
                            <table class="claimhistorydata">
                                <thead>
                                <th style="width:10%;"><label class="titles">Year</label></th>
                                <th><label class="titles">Type</label></th>
                                <th><label class="titles">Minor injury claim amount</label></th>
                                <th><label class="titles">Death claim amount</label></th>
                                <th><label class="titles">Cost & Description</label></th>
                                </thead>
                                <tbody>
                                    @foreach($formValues['eQuestionnaire']['policyDetails']['claimsHistory'] as $claimHistory)
                                    @if ((strtolower(@$formValues['eQuestionnaire']['businessDetails']['employeeDetails']['adminStatus']) == strtolower(str_replace(' ', '', @$claimHistory['type']))) || (@$formValues['eQuestionnaire']['businessDetails']['employeeDetails']['adminStatus'] == 'both'))
                                        <tr>
                                            <td>{{str_replace('year', '', @$claimHistory['year'])}} &nbsp
                                            @if($loop->iteration == 1 ||  $loop->iteration == 2)
                                            (Most Recent)
                                            @endif
                                            </td>
                                            <td>{{@$claimHistory['type']?:'--'}}</td>
                                            <td><p>{{@$claimHistory['minor_injury_claim_amount']?:'--'}}</p></td>
                                            <td><p>{{@$claimHistory['death_claim_amount']?:'--'}}</p></td>
                                            <td><p>{{@$claimHistory['cost_&_Description']?:'--'}}</p></td>
                                        </tr>
                                    @endif
                                @endforeach
                                </tbody>
                            </table>
                            </div>
                        </div>
                    @endif
                @endif
            </div>
        </div>
        <!------------col-8 end-->

        <!------------ forms col-4 start-->
        <div class="col-4 eslip_rightscroll">
            <div  class="datatitle">
            <div class="row">
                <div class="col-12">
                    <div class="form-group">
                        <label><b class="blue">Please fill all the required data</b></label>
                    </div>
                    </div>
                </div>
                </div>
                <br>
                <div  class="contentbody">
                <div class=" row">
                    <div class="col-12">
                    <div class="form-group">
                        @widget("EslipWidget",['data' => @$formData, 'step' => @$step, 'workTypeId' => @$workTypeId, 'stage' =>@$stage, 'values' => @$values, 'formValues' => $formValues, 'workTypeDataId' => $workTypeDataId, 'reviewArr' => @$reviewArr,'company_id' => @$company_id, 'insurer_list' => @$insurer_list, 'documents' => @$documents ])
                    </div>
                    </div>
                </div>
                </div>
            </div>
            </div>
        </div>
    </div> <!--main row end-->

<style>
  .qus_title {
    width: 50%;
  }
  td.colon {
    width: 30px;
    text-align: center;
  }
  .borderless_table{
    width: 100% !important;
  }

  .borderless_table td{
    border: none;
    padding: 2px 0;
  }

</style>
@endsection

@push('widgetScripts')
<script>

    function equestionnareInputSave(elem , saveFields) {
        elemValue = parseInt(elem.value.replace(/,/g , '').trim());
        $.ajax({
            method: 'post',
            url: '{{url('equestionare-field-save')}}',
            data: {
                _token : '{{csrf_token()}}',
                elemValue:elemValue,
                saveFields:saveFields,
                workTypeDataId :'{{ $workTypeDataId}}'
            }
        });
    }

$(function () {
  let show = 'show';

  $('input').on('checkval', function () {
    let label = $(this).next('label');
    if(this.value !== '') {
      label.addClass(show);
   } else {
      label.removeClass(show);
    }
  }).on('keyup', function () {
    $(this).trigger('checkval');
  });
});


$(function () {
  let show = 'show';

  $('textarea').on('checkval', function () {
    let label = $(this).next('label');
    if(this.value !== '') {
      label.addClass(show);
   } else {
      label.removeClass(show);
    }
  }).on('keyup', function () {
    $(this).trigger('checkval');
  });
});

        </script>
       <!--scripts-->
  @endpush


