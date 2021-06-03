

 @if (isset($config['isLocationRelated']) && $config['isLocationRelated'])
    <?php @eval("\$viewItm = \"{$config['locationCheckValue']}\";"); ?>
    @if (in_array($viewItm, $config['locationMatchValue']))
        @if (isset($config['isBusinessRelated']) && $config['isBusinessRelated'] === True)
            @if (count($config['relatedBusiness']) > 0)
                @if (in_array (@$formValues['eQuestionnaire']['businessDetails']['businessType']['optionId'], $config['relatedBusiness']))
                    <table class="borderless_table">
                        {{-- <tr class="form-group">
                            <td class="qus_title"><label><b class="titles">{{@$config['label']}}</b></label></td>
                            <td class="colon">:</td> --}}
                            @if (@$config['valuesRequired'])
                                @if (isset($config['table']))
                                    @foreach ($config['table'] as $item)
                                    <?php @eval("\$columnValue = \"{$item['columnValue']}\";"); ?>
                                        @if ($columnValue)
                                            <tr class="form-group">
                                                @if ($loop->iteration == 1)
                                                    <td class="qus_title"><label><b class="titles">{{@$config['label']}}</b></label></td>
                                                    <td class="colon">:</td>
                                                @else
                                                    <td class="qus_title"><label><b class="titles"></b></label></td>
                                                    <td class="colon"></td>
                                                @endif
                                                @if(isset($item['fromArr']) && !empty($item['valArr']))
                                                <?php $columnValue = @$item['valArr'][$columnValue]; ?>
                                                @endif
                                                <td><label class="titles">{{@$item['columnName']}} - {{@$columnValue}}</label></td>
                                                {{-- <td class="colon">-</td>
                                                <td><label class="titles">{{@$columnValue}}</label></td> --}}
                                            </tr>
                                        @endif
                                    @endforeach
                                @endif
                            @else
                            <tr>
                                <td><label class="titles">--</label></td>
                            </tr>
                            @endif
                        {{-- </tr> --}}
                    </table>
                @endif
            @endif
        @elseif (isset($config['isWidgetRelated']) && $config['isWidgetRelated'] === True)
            <?php @eval("\$str = \"{$config['checkValue']}\";"); ?>
            @if (count(@$config['matchValue']) > 0)
                @if (in_array (@$str, $config['matchValue']))
                <table class="borderless_table">
                    {{-- <tr class="form-group">
                        <td class="qus_title"><label><b class="titles">{{@$config['label']}}</b></label></td>
                        <td class="colon">:</td> --}}
                        @if (@$config['valuesRequired'])
                            @if (isset($config['table']))
                                @foreach ($config['table'] as $item)
                                <tr class="form-group">
                                    @if ($loop->iteration == 1)
                                        <td class="qus_title"><label><b class="titles">{{@$config['label']}}</b></label></td>
                                        <td class="colon">:</td>
                                    @else
                                    <td class="qus_title"><label><b class="titles"></b></label></td>
                                    <td class="colon"></td>
                                    @endif
                                    <?php @eval("\$columnValue = \"{$item['columnValue']}\";"); ?>
                                    @if(isset($item['fromArr']) && !empty($item['valArr']))
                                            <?php $columnValue = @$item['valArr'][$columnValue]; ?>
                                                @endif
                                    <td><label class="titles">{{@$item['columnName']}} - {{@$columnValue}}</label></td>
                                    {{-- <td class="colon">-</td>
                                    <td><label class="titles">{{@$columnValue}}</label></td> --}}
                                </tr>
                                @endforeach
                            @endif
                        @else
                        <tr>
                            <td><label class="titles">--</label></td>
                        </tr>
                        @endif
                    </tr>
                </table>
                @endif
            @endif
        @else
            <table class="borderless_table">
                {{-- <tr class="form-group">
                    <td class="qus_title"><label><b class="titles">{{@$config['label']}}</b></label></td>
                    <td class="colon">:</td> --}}
                    @if (@$config['valuesRequired'])
                        @if (isset($config['table']))
                            @foreach ($config['table'] as $item)
                            <tr class="form-group">
                                @if ($loop->iteration == 1)
                                    <td class="qus_title"><label><b class="titles">{{@$config['label']}}</b></label></td>
                                    <td class="colon">:</td>
                                @else
                                <td class="qus_title"><label><b class="titles"></b></label></td>
                                <td class="colon"></td>
                                @endif
                                <?php @eval("\$columnValue = \"{$item['columnValue']}\";"); ?>
                                @if(isset($item['fromArr']) && !empty($item['valArr']))
                                        <?php $columnValue = @$item['valArr'][$columnValue]; ?>
                                            @endif
                                <td><label class="titles">{{@$item['columnName']}} - {{@$columnValue}}</label></td>
                                {{-- <td class="colon">-</td>
                                <td><label class="titles">{{@$columnValue}}</label></td> --}}
                            </tr>
                            @endforeach
                        @endif
                    @else
                    <tr>
                        <td><label class="titles">--</label></td>
                    </tr>
                    @endif
                </tr>
            </table>
        @endif
    @endif
@else
    @if (isset($config['isBusinessRelated']) && $config['isBusinessRelated'] === True)
        @if (count($config['relatedBusiness']) > 0)
            @if (in_array (@$formValues['eQuestionnaire']['businessDetails']['businessType']['optionId'], $config['relatedBusiness']))
                <table class="borderless_table">
                    {{-- <tr class="form-group">
                        <td class="qus_title"><label><b class="titles">{{@$config['label']}}</b></label></td>
                        <td class="colon">:</td> --}}
                        @if (@$config['valuesRequired'])
                            @if (isset($config['table']))
                                @foreach ($config['table'] as $item)
                                <?php @eval("\$columnValue = \"{$item['columnValue']}\";"); ?>
                                    @if ($columnValue)
                                        <tr class="form-group">
                                            @if ($loop->iteration == 1)
                                                <td class="qus_title"><label><b class="titles">{{@$config['label']}}</b></label></td>
                                                <td class="colon">:</td>
                                            @else
                                                <td class="qus_title"><label><b class="titles"></b></label></td>
                                                <td class="colon"></td>
                                            @endif
                                            @if(isset($item['fromArr']) && !empty($item['valArr']))
                                            <?php $columnValue = @$item['valArr'][$columnValue]; ?>
                                            @endif
                                            <td><label class="titles">{{@$item['columnName']}} - {{@$columnValue}}</label></td>
                                            {{-- <td class="colon">-</td>
                                            <td><label class="titles">{{@$columnValue}}</label></td> --}}
                                        </tr>
                                    @endif
                                @endforeach
                            @endif
                        @else
                        <tr>
                            <td><label class="titles">--</label></td>
                        </tr>
                        @endif
                    {{-- </tr> --}}
                </table>
            @endif
        @endif
    @elseif (isset($config['isWidgetRelated']) && $config['isWidgetRelated'] === True)
        <?php @eval("\$str = \"{$config['checkValue']}\";"); ?>
        @if (count(@$config['matchValue']) > 0)
            @if (in_array (@$str, $config['matchValue']))
            <table class="borderless_table">
                {{-- <tr class="form-group">
                    <td class="qus_title"><label><b class="titles">{{@$config['label']}}</b></label></td>
                    <td class="colon">:</td> --}}
                    @if (@$config['valuesRequired'])
                        @if (isset($config['table']))
                            @foreach ($config['table'] as $item)
                                @if (isset($item['isWidgetRelated']) && $item['isWidgetRelated'] === True)
                                    <?php @eval("\$str = \"{$item['checkValue']}\";"); ?>                                       
                                    @if (in_array (@$str, $item['matchValue']))                                             
                                        @if(isset($item['value']) && !empty($item['value']))
                                            <?php $columnValue = @$item['value']; ?>
                                        @endif 
                                    @else 
                                     <?php $columnValue = "" ?>
                                    @endif 
                                @else
                                <?php @eval("\$columnValue = \"{$item['columnValue']}\";"); ?>
                                @if(isset($item['fromArr']) && !empty($item['valArr']))
                                           <?php $columnValue = @$item['valArr'][$columnValue]; ?>
                                            {{--  <td><label class="titles">{{@$item['columnName']}} - {{@$columnValue}}</label></td>  --}}
                                            @endif
                                @endif 
                                 @if(@$columnValue)
                                   <tr class="form-group">
                                    @if ($loop->iteration == 1)
                                        <td class="qus_title"><label><b class="titles">{{@$config['label']}}</b></label></td>
                                        <td class="colon">:</td>
                                    @else
                                    <td class="qus_title"><label><b class="titles"></b></label></td>
                                    <td class="colon"></td>
                                    @endif 
                                    <td><label class="titles">{{@$item['columnName']}} - {{@$columnValue}}</label></td>
                                    </tr>
                                 @endif
                            @endforeach
                        @endif
                    @else
                    <tr>
                        <td><label class="titles">--</label></td>
                    </tr>
                    @endif
                </tr>
            </table>
            @endif
        @endif
    @else
        <table class="borderless_table">
            {{-- <tr class="form-group">
                <td class="qus_title"><label><b class="titles">{{@$config['label']}}</b></label></td>
                <td class="colon">:</td> --}}
                @if (@$config['valuesRequired'])
                    @if (isset($config['table']))
                        @foreach ($config['table'] as $item)
                        <tr class="form-group">
                            @if ($loop->iteration == 1)
                                <td class="qus_title"><label><b class="titles">{{@$config['label']}}</b></label></td>
                                <td class="colon">:</td>
                            @else
                            <td class="qus_title"><label><b class="titles"></b></label></td>
                            <td class="colon"></td>
                            @endif
                            <?php @eval("\$columnValue = \"{$item['columnValue']}\";"); ?>
                            @if(isset($item['fromArr']) && !empty($item['valArr']))
                                    <?php $columnValue = @$item['valArr'][$columnValue]; ?>
                                        @endif
                            <td><label class="titles">{{@$item['columnName']}} - {{@$columnValue}}</label></td>
                            {{-- <td class="colon">-</td>
                            <td><label class="titles">{{@$columnValue}}</label></td> --}}
                        </tr>
                        @endforeach
                    @endif
                @else
                <tr>
                    <td><label class="titles">--</label></td>
                </tr>
                @endif
            </tr>
        </table>
    @endif
@endif



