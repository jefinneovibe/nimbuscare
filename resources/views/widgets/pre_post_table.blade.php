<div @if (isset($config['style']['col_width'])) class="col-{{$config['style']['col_width']}}" @endif >
    <table id="premiseTable" style="border: 1px solid #D6D6D6;" class="table testtable">
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
                            <th>
                                <div class="input-group">
                                    @if (isset($rowHeader['aed']) && $rowHeader['aed'])
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">AED</span>
                                        </div>
                                    @endif
                                    <input type="text" name="{{@$config['fieldName']}}[{{@$fieldArray}}][{{@$rowHeader['feildName']}}]" value="{{$value[$fieldArray][$rowHeader['feildName']]}}" class="form-control {{@$rowHeader['class']}}" placeholder="Enter here" aria-invalid="false">
                                </div>
                            </th>
                        @endforeach
                    </tr>
                @endfor
            @endif

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
        $(window).load(function(){
            $("#premiseTable .aed").each(function() {
                $(this).rules("add", {
                    amount : true
                });
                $(this).rules("add", {
                    messages: {
                        amount : 'Enter digits only.'
                    }
                });
            });
        });
    </script>
@endpush
