<div @if (isset($config['style']['col_width'])) class="col-{{$config['style']['col_width']}}" @endif >
    @if (@$config['label'])
        <h6 class="title">{{@$config['label']}}</h6>
    @endif
    <table id="{{@$config['id']}}" style="border: 1px solid #D6D6D6;" class="table testtable">
        @if (isset($config['columnHeader']) && !empty($config['columnHeader']))
            <thead>
                <tr>
                    @foreach ($config['columnHeader'] as $tHead)
                        <th>{{@$tHead['label']}}</th>
                    @endforeach
                </tr>
            </thead>
        @endif
        @if (isset($config['rowArray']) && !empty($config['rowArray']))
            @foreach ($config['rowArray'] as $eachTr)
                <tr>
                    @foreach ($eachTr as $eachTd)
                        <td style="padding-top: 10px;">
                            @if (isset($eachTd['isLabel']) && $eachTd['isLabel'])
                                <label><b class="titles">{{@$eachTd['label']}} <span>*</span></b></label>
                            @elseif (isset($eachTd['isWidget']) && $eachTd['isWidget'])
                                @if (isset($eachTd['widgetConfig']) && !empty($eachTd['widgetConfig']))
                                    @widget($eachTd['widgetConfig']['widgetType'], ['data' => $eachTd['widgetConfig']['config'], 'workTypeId'=> @$workTypeId, 'value' => @$value[$eachTd['widgetConfig']['config']['valueKey']]])
                                @endif
                            @elseif (isset($eachTd['isTotal']) && $eachTd['isTotal'])
                            @push('widgetScripts')
                                <script>
                                    $(document).on('keyup',".{{@$eachTd['classForTotal']}}",function(){
                                        var parentId = $(this).offsetParent().offsetParent().offsetParent().parent().children().children().last().attr("id");
                                        calculateBasicTableTotal("{{@$eachTd['classForTotal']}}",parentId);
                                    });
                                </script>
                            @endpush
                            <div class="col-{{@$eachTd['widgetConfig']['config']['style']['col_width']?:6}}">
                                <div class="row">
                                    <div class="{{@$eachTd['widgetConfig']['config']['field_class']?:'col-12'}}">
                                        <div class="form-group">
                                            @if (@$eachTd['widgetConfig']['config']['aed'])
                                                <div  @if(@$eachTd['widgetConfig']['config']['elem_width']) style="max-width: {{@$eachTd['widgetConfig']['config']['elem_width']}}" @endif class="input-group">
                                                    @if(isset($eachTd['widgetConfig']['config']['aed']))
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">AED</span>
                                                        </div>
                                                    @endif
                                                    <input
                                                    readonly onchange="calculateBasicTableTotal('{{@$eachTd['classForTotal']}}', '{{@$config['id']}}')"
                                                        @if (@$eachTd['widgetConfig']['config']['class'])
                                                            class=" @foreach ($eachTd['widgetConfig']['config']['class'] as $Classkey1 => $className) {{ $className }} @endforeach @if(isset($eachTd['widgetConfig']['config']['aed'])) aed @endif  form-control"
                                                        @else
                                                            class=" @if(isset($eachTd['widgetConfig']['config']['aed'])) aed @endif  form-control"
                                                        @endif
                                                    type="text"   name="{{$eachTd['widgetConfig']['config']['fieldName']}}" id="{{@$eachTd['classForTotal']}}_inputBasicTableTotal"

                                                    @if (isset($value[$eachTd['widgetConfig']['config']['valueKey']]) && $value[$eachTd['widgetConfig']['config']['valueKey']] != '' && !isset($eachTd['widgetConfig']['config']['value']))
                                                        value="{{@$value[$eachTd['widgetConfig']['config']['valueKey']]}}"
                                                    @elseif(isset($eachTd['widgetConfig']['config']['value']))
                                                        <?php  @eval("\$str = \"{$eachTd['widgetConfig']['config']['value']}\";"); ?>
                                                        value="{{@$str}}"
                                                    @elseif(isset($eachTd['widgetConfig']['config']['defaultValue']) && $eachTd['widgetConfig']['config']['defaultValue'] != '')
                                                        value="{{@$eachTd['widgetConfig']['config']['defaultValue']}}"
                                                    @endif
                                                    placeholder="{{$eachTd['widgetConfig']['config']['placeHolder']}}">
                                                </div>
                                            @else
                                            <input
                                            readonly onchange="calculateBasicTableTotal('{{@$eachTd['classForTotal']}}', '{{@$config['id']}}')"
                                            type="text"
                                            @if (@$eachTd['widgetConfig']['config']['class'])
                                                class=" @foreach ($eachTd['widgetConfig']['config']['class'] as $Classkey1 => $className) {{ $className }} @endforeach form-control"
                                            @else
                                                class="form-control"
                                            @endif
                                            name="{{$eachTd['widgetConfig']['config']['fieldName']}}"
                                            @if(@$eachTd['widgetConfig']['config']['elem_width']) style="max-width: {{@$eachTd['widgetConfig']['config']['elem_width']}}" @endif
                                            id="{{@$eachTd['classForTotal']}}_inputBasicTableTotal"
                                            @if (isset($value[$eachTd['widgetConfig']['config']['valueKey']]) && $value[$eachTd['widgetConfig']['config']['valueKey']] != '')
                                                value="{{@$value[$eachTd['widgetConfig']['config']['valueKey']]}}"
                                            @elseif(isset($eachTd['widgetConfig']['config']['value']))
                                                <?php @eval("\$str = \"{$eachTd['widgetConfig']['config']['value']}\";"); ?>
                                                value="{{@$str}}"
                                            @elseif(isset($eachTd['widgetConfig']['config']['defaultValue']) && $eachTd['widgetConfig']['config']['defaultValue'] != '')
                                                value="{{@$eachTd['widgetConfig']['config']['defaultValue']}}"
                                            @endif
                                            placeholder="{{$eachTd['widgetConfig']['config']['placeHolder']}}">
                                            @endif

                                        </div>
                                    </div>
                                </div>

                            </div>
                            @endif
                        </td>
                    @endforeach
                </tr>
            @endforeach
        @endif
        <tbody>

        </tbody>
    </table>
</div>
<style>
.testtable tbody tr td, .testtable thead tr th{
    height: 25px !important;
}

</style>

@push('widgetScripts')
    <script>
        function calculateBasicTableTotal(classForTotal, tableId) {
            var total=0;
            $( '#'+tableId ).find('.'+classForTotal).each(function( index ) {
                thisNum = $(this).val().replace(/,/g, "");
                total+=Number(thisNum);
            });
            $('#'+classForTotal+'_inputBasicTableTotal').val(String(total).replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ","));
        }
    </script>
@endpush
