<br/>
@if (isset($config['rowHeader']))
    @for($i = 0; $i<2; $i++)
        <?php $fieldArray = '';  $exist= 0;?>
        @if ($i == 0)
            <?php $fieldArray = 'atYourPremises'; ?>
        @elseif ($i == 1 )
                <?php $fieldArray = 'awayFromYourPremises'; ?>
        @endif
        @foreach ($config['rowHeader'] as $key => $rowHeader)
            <?php
                $position1 = strrpos($config['valueField'], '}');
                $textValue1 =substr_replace( $config['valueField'], "[$fieldArray][$rowHeader[feildName]]", $position1, 0 );
                @eval("\$valueField1 = \"{$textValue1}\";");
                if ($valueField1 != '') {
                    $exist = 1;
                }
            ?>
        @endforeach
    @endfor
@endif
@if ($exist == 1)

    <div>
        <h6 class="titles"><b>{{@$config['label']}}</b></h6>
    </div>

    <table class="table testtable">
        <thead>
            @if (isset($config['tableHeader']))
                <tr>
                    <th></th>
                    @foreach ($config['tableHeader'] as $eachTd)
                        <th @if (isset($eachTd['colSpan'])) colspan="{{$eachTd['colSpan']}}" @endif>
                            {{@$eachTd['label']}}
                        </th>
                    @endforeach
                </tr>
            @endif
            @if (isset($config['rowHeader']))
                <tr>
                    <th></th>
                    @foreach ($config['rowHeader'] as $rowHeader)
                        <th>{{@$rowHeader['label']}}</th>
                    @endforeach
                </tr>
            @endif
        </thead>
        <tbody>
            @if (isset($config['rowHeader']))
                @for($i = 0; $i<2; $i++)
                    <?php $fieldArray = ''; ?>
                    <tr>
                        @if ($i == 0)
                            <?php $fieldArray = 'atYourPremises'; ?>
                            <td>
                                <label><b class="titles">(i) at your Premises <span>*</span></b></label>
                            </td>
                        @elseif ($i == 1 )
                                <?php $fieldArray = 'awayFromYourPremises'; ?>
                            <td>
                                <label><b class="titles">(ii) away from your Premises <span>*</span></b></label>
                            </td>
                        @endif
                        @foreach ($config['rowHeader'] as $key => $rowHeader)
                            <?php
                                $position = strrpos($config['valueField'], '}');
                                $textValue =substr_replace( $config['valueField'], "[$fieldArray][$rowHeader[feildName]]", $position, 0 );
                                @eval("\$valueField = \"{$textValue}\";");
                            ?>
                            <td>
                                <label>
                                    {{@$valueField}}
                                </label>
                            </td>
                        @endforeach
                    </tr>
                @endfor
            @endif
        </tbody>
    </table>
@endif
