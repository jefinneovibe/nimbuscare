
<style>
    .eslipBasicTable {
      border-collapse: collapse;
      border: 1px solid #ddd;
      width: 100%;
    }
    .eslipBasicTable th {
        background-color: #f2f2f2;
        padding: 15px;
    }
    .eslipBasicTable td {
      padding: 8px;
      text-align: left;
      border-bottom: 1px solid #ddd;
    }
    .basicTableTitle {
        font-size: 11px;
        margin-bottom: 10px;
        margin-top: 10px;
    }
    </style>

 @if (isset($config['isLocationRelated']) && $config['isLocationRelated'])
    <?php @eval("\$viewItm = \"{$config['locationCheckValue']}\";"); ?>
    @if (in_array($viewItm, $config['locationMatchValue']))
        @if (isset($config['isBusinessRelated']) && $config['isBusinessRelated'] === True)
            @if (count($config['relatedBusiness']) > 0)
                @if (in_array (@$formValues['eQuestionnaire']['businessDetails']['businessType']['optionId'], $config['relatedBusiness']))
                    @if ((isset($config['columnHeader']) && !empty($config['columnHeader'])) || (isset($config['rowArray']) && !empty($config['rowArray'])) )
                        @if (@$config['label'])
                            <h6 class="basicTableTitle">{{@$config['label']}}</h6>
                        @endif
                        <table class="eslipBasicTable">
                            <tr>
                                @foreach ($config['columnHeader'] as $eachHead)
                                    <th>
                                        {{@$eachHead['label']}}
                                    </th>
                                @endforeach
                            </tr>
                            @foreach ($config['rowArray'] as $rowArray)
                                <tr>
                                    @foreach ($rowArray as $eahTD)
                                        @if (isset($eahTD['isLabel']) &&$eahTD['isLabel'])
                                            <td class="qus_title"><label><b class="titles">{{@$eahTD['label']}}</b></label></td>
                                        @elseif (isset($eahTD['isWidget']) &&$eahTD['isWidget'])
                                            <?php @eval("\$columnValue = \"{$eahTD['value']}\";"); ?>
                                            <td><label class="titles">{{@$columnValue}}</label></td>
                                        @endif
                                    @endforeach
                                </tr>
                            @endforeach
                        </table>
                    @endif
                @endif
            @endif
        @elseif (isset($config['isWidgetRelated']) && $config['isWidgetRelated'] === True)
            <?php @eval("\$str = \"{$config['checkValue']}\";"); ?>
            @if (count(@$config['matchValue']) > 0)
                @if (in_array (@$str, $config['matchValue']))
                    @if ((isset($config['columnHeader']) && !empty($config['columnHeader'])) || (isset($config['rowArray']) && !empty($config['rowArray'])) )
                        @if (@$config['label'])
                            <h6 class="basicTableTitle">{{@$config['label']}}</h6>
                        @endif
                        <table class="eslipBasicTable">
                            <tr>
                                @foreach ($config['columnHeader'] as $eachHead)
                                    <th>
                                        {{@$eachHead['label']}}
                                    </th>
                                @endforeach
                            </tr>
                            @foreach ($config['rowArray'] as $rowArray)
                                <tr>
                                    @foreach ($rowArray as $eahTD)
                                        @if (isset($eahTD['isLabel']) &&$eahTD['isLabel'])
                                            <td class="qus_title"><label><b class="titles">{{@$eahTD['label']}}</b></label></td>
                                        @elseif (isset($eahTD['isWidget']) &&$eahTD['isWidget'])
                                            <?php @eval("\$columnValue = \"{$eahTD['value']}\";"); ?>
                                            <td><label class="titles">{{@$columnValue}}</label></td>
                                        @endif
                                    @endforeach
                                </tr>
                            @endforeach
                        </table>
                    @endif
                @endif
            @endif
        @else
            @if ((isset($config['columnHeader']) && !empty($config['columnHeader'])) || (isset($config['rowArray']) && !empty($config['rowArray'])) )
                @if (@$config['label'])
                    <h6 class="basicTableTitle">{{@$config['label']}}</h6>
                @endif
                <table class="eslipBasicTable">
                    <tr>
                        @foreach ($config['columnHeader'] as $eachHead)
                            <th>
                                {{@$eachHead['label']}}
                            </th>
                        @endforeach
                    </tr>
                    @foreach ($config['rowArray'] as $rowArray)
                        <tr>
                            @foreach ($rowArray as $eahTD)
                                @if (isset($eahTD['isLabel']) &&$eahTD['isLabel'])
                                    <td class="qus_title"><label><b class="titles">{{@$eahTD['label']}}</b></label></td>
                                @elseif (isset($eahTD['isWidget']) &&$eahTD['isWidget'])
                                    <?php @eval("\$columnValue = \"{$eahTD['value']}\";"); ?>
                                    <td><label class="titles">{{@$columnValue}}</label></td>
                                @endif
                            @endforeach
                        </tr>
                    @endforeach
                </table>
            @endif
        @endif
    @endif
@else
    @if (isset($config['isBusinessRelated']) && $config['isBusinessRelated'] === True)
        @if (count($config['relatedBusiness']) > 0)
            @if (in_array (@$formValues['eQuestionnaire']['businessDetails']['businessType']['optionId'], $config['relatedBusiness']))
                @if ((isset($config['columnHeader']) && !empty($config['columnHeader'])) || (isset($config['rowArray']) && !empty($config['rowArray'])) )
                    @if (@$config['label'])
                        <h6 class="basicTableTitle">{{@$config['label']}}</h6>
                    @endif
                    <table class="eslipBasicTable">
                        <tr>
                            @foreach ($config['columnHeader'] as $eachHead)
                                <th>
                                    {{@$eachHead['label']}}
                                </th>
                            @endforeach
                        </tr>
                        @foreach ($config['rowArray'] as $rowArray)
                            <tr>
                                @foreach ($rowArray as $eahTD)
                                    @if (isset($eahTD['isLabel']) &&$eahTD['isLabel'])
                                        <td class="qus_title"><label><b class="titles">{{@$eahTD['label']}}</b></label></td>
                                    @elseif (isset($eahTD['isWidget']) &&$eahTD['isWidget'])
                                        <?php @eval("\$columnValue = \"{$eahTD['value']}\";"); ?>
                                        <td><label class="titles">{{@$columnValue}}</label></td>
                                    @endif
                                @endforeach
                            </tr>
                        @endforeach
                    </table>
                @endif
            @endif
        @endif
    @elseif (isset($config['isWidgetRelated']) && $config['isWidgetRelated'] === True)
        <?php @eval("\$str = \"{$config['checkValue']}\";"); ?>
            @if (count(@$config['matchValue']) > 0)
                @if (in_array (@$str, $config['matchValue']))
                    @if ((isset($config['columnHeader']) && !empty($config['columnHeader'])) || (isset($config['rowArray']) && !empty($config['rowArray'])) )
                        @if (@$config['label'])
                            <h6 class="basicTableTitle">{{@$config['label']}}</h6>
                        @endif
                        <table class="eslipBasicTable">
                            <tr>
                                @foreach ($config['columnHeader'] as $eachHead)
                                    <th>
                                        {{@$eachHead['label']}}
                                    </th>
                                @endforeach
                            </tr>
                            @foreach ($config['rowArray'] as $rowArray)
                                <tr>
                                    @foreach ($rowArray as $eahTD)
                                        @if (isset($eahTD['isLabel']) &&$eahTD['isLabel'])
                                            <td class="qus_title"><label><b class="titles">{{@$eahTD['label']}}</b></label></td>
                                        @elseif (isset($eahTD['isWidget']) &&$eahTD['isWidget'])
                                            <?php @eval("\$columnValue = \"{$eahTD['value']}\";"); ?>
                                            <td><label class="titles">{{@$columnValue}}</label></td>
                                        @endif
                                    @endforeach
                                </tr>
                            @endforeach
                        </table>
                    @endif
                @endif
            @endif
    @else
        @if ((isset($config['columnHeader']) && !empty($config['columnHeader'])) || (isset($config['rowArray']) && !empty($config['rowArray'])) )
            @if (@$config['label'])
                <h6 class="basicTableTitle">{{@$config['label']}}</h6>
            @endif
            <table class="eslipBasicTable">
                <tr>
                    @foreach ($config['columnHeader'] as $eachHead)
                        <th>
                            {{@$eachHead['label']}}
                        </th>
                    @endforeach
                </tr>
                @foreach ($config['rowArray'] as $rowArray)
                    <tr>
                        @foreach ($rowArray as $eahTD)
                            @if (isset($eahTD['isLabel']) &&$eahTD['isLabel'])
                                <td class="qus_title"><label><b class="titles">{{@$eahTD['label']}}</b></label></td>
                            @elseif (isset($eahTD['isWidget']) &&$eahTD['isWidget'])
                                <?php @eval("\$columnValue = \"{$eahTD['value']}\";"); ?>
                                <td><label class="titles">{{@$columnValue}}</label></td>
                            @endif
                        @endforeach
                    </tr>
                @endforeach
            </table>
        @endif
    @endif
@endif



