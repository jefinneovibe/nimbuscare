
<?php $showWidget = false; ?>

@if (isset($config['isLocationRelated']) && $config['isLocationRelated'])
    <?php @eval("\$viewItm = \"{$config['locationCheckValue']}\";"); ?>
    @if (in_array($viewItm, $config['locationMatchValue']))
        <?php $showWidget = true; ?>
    @endif
@else
    @if (isset($config['isBusinessRelated']) && $config['isBusinessRelated'] === True)
        @if (count($config['relatedBusiness']) > 0)
            @if (in_array (@$formValues['eQuestionnaire']['businessDetails']['businessType']['optionId'], $config['relatedBusiness']))
                <?php $showWidget = true; ?>
            @endif
        @endif
    @elseif (isset($config['isWidgetRelated']) && $config['isWidgetRelated'] === True)
        <?php @eval("\$str = \"{$config['checkValue']}\";"); ?>
        @if (count(@$config['matchValue']) > 0)
            @if (in_array (@$str, $config['matchValue']))
                <?php $showWidget = true; ?>
            @endif
        @endif
    @else
        <?php $showWidget = true; ?>
    @endif
@endif

    @if (@$config['value'] && $showWidget == true)

        <style>
            .safe_details{
                width: 100%;
                margin-bottom: 8px;
                margin-left: 1%;
            }
            .safe_details td,
            .safe_details th{
                border: 1px solid #d6d6d6;
                padding: 4px 4px
            }
            .safe_details th {
                background: #edf0f3;
            }
        </style>
        <h6 style="margin: 12px 0 8px 0;font-weight: 600;font-size: 13px;">{{@$config['label']}}</h6>
        <table class="safe_details col-{{@$config['style']['col_width']}}">
            <thead>
                <?php
                    $array1=[];
                    for($i=0;$i<count($config['value']);$i++){
                        $array1[$i]['location']=$config['value'][$i]['columnValue'];
                        $array1[$i]['labelName']=$config['value'][$i]['columnName'];
                        ?>
                        <th>{{$config['value'][$i]['columnName']}}</th>
                        <?php
                    }
                ?>
            </thead>
            <tbody>
                <?php
                    for($k=0;$k<10;$k++){
                        ?>
                    <tr>
                        <?php
                        for($j=0;$j< count($array1);$j++){
                            $text=$array1[$j]['location'];
                            $position = strrpos($text, '}');
                            $textValue =substr_replace( $text, '['.$k.']', $position, 0 );
                            @eval("\$arrayVal = \"{$textValue}\";");
                            if ($arrayVal != ''){
                            ?>
                                <td><label class="titles">{{@$arrayVal}}</label></td>
                            <?php
                            }
                        }
                        ?>
                    </tr>
                        <?php
                    }
                ?>
            </tbody>
        </table>
    @endif
