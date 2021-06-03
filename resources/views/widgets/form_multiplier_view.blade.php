@if (@$ldetails)
<style>
#hiddenScrolltoMl td, #hiddenScrolltoMl th{
    border: .0625rem solid #D6D6D6 !important;
}
</style>
    <table class="table formMultiView" id="hiddenScrolltoMl">
        <thead>
            @foreach($ldetails as $key => $val)
                @if ($loop->iteration == 1)
                    <tr>
                        @foreach ($val as $fieldName => $fieldValue)
                            @if (!empty(@$DetailJson))
                                @foreach ($DetailJson as $detailJson)
                                    @if (isset($detailJson['fields']))
                                        @foreach (@$detailJson['fields'] as $eachConfig)
                                            @if (isset($eachConfig['config']['viewStatus']) && @$eachConfig['config']['viewStatus'])
                                                 @if (isset($eachConfig['config']) && @$eachConfig['config']['fieldName'] ==  $fieldName)
                                                    <th>
                                                        <label class="title">  {{ $eachConfig['config']['label']}}</label>
                                                    </th>
                                                @endif
                                            @endif
                                        @endforeach
                                    @endif
                                @endforeach
                            @endif
                        @endforeach
                        <th>

                        </th>
                    </tr>
                @endif
            @endforeach
        </thead>
        <tbody>
            @foreach($ldetails as $key => $val)
                <tr>
                    @foreach ($val as $fieldName => $fieldValue)
                        @if (!empty(@$DetailJson))
                            @foreach ($DetailJson as $detailJson)
                                @if (isset($detailJson['fields']))
                                    @foreach (@$detailJson['fields'] as $eachConfig)
                                        @if (isset($eachConfig['config']['viewStatus']) && @$eachConfig['config']['viewStatus'])
                                                @if (isset($eachConfig['config']) && @$eachConfig['config']['fieldName'] ==  $fieldName)
                                                <td>
                                                    <label  class="titiles">
                                                        @if (isset($eachConfig['config']['isArray']) && $eachConfig['config']['isArray'] && isset($fieldValue[$eachConfig['config']['arrayKey']]))
                                                            {{@$fieldValue[$eachConfig['config']['arrayKey']]}}
                                                        @else
                                                            {{$fieldValue}}
                                                        @endif
                                                    </label>
                                                </td>
                                                @endif
                                        @endif
                                    @endforeach
                                @endif
                            @endforeach
                        @endif
                    @endforeach
                    <td class="text-center">
                        <button type="button" class="btn btn-primary btn-sm btnxsm" data-toggle="modal" data-target="#multiForm_popup" onclick="showSingleValue('{{$key}}' , '{{$valueKey}}', '{{@$workTypeDataId}}')"  id="view_form_btn">view/Edit</button>
                        <button  type="button" class="btn btnred btn-sm btnxsm" data-toggle="modal" data-target="#delete_popup" onclick="deleteSingleValue('{{$key}}', '{{$valueKey}}', '{{@$workTypeDataId}}')"  id="delete_form_btn">Delete</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endif

    {{-- <div id="hiddenScrolltoMl">
        @foreach($ldetails as $key => $val)
            <div class="row" style="margin-top:12px;">
                @foreach ($val as $fieldName => $fieldValue)
                    @if (!empty(@$DetailJson))
                        @foreach ($DetailJson as $detailJson)
                            @if (isset($detailJson['fields']))
                                @foreach (@$detailJson['fields'] as $eachConfig)
                                    @if (isset($eachConfig['config']['viewStatus']) && @$eachConfig['config']['viewStatus'])
                                            @if (isset($eachConfig['config']) && @$eachConfig['config']['fieldName'] ==  $fieldName)
                                                <div class="col-3">
                                                    <label class="title"> {{ $eachConfig['config']['label']}} </label>
                                                        <span class="text">
                                                            @if (isset($eachConfig['config']['isArray']) && $eachConfig['config']['isArray'] && isset($fieldValue[$eachConfig['config']['arrayKey']]))
                                                                {{@$fieldValue[$eachConfig['config']['arrayKey']]}}
                                                             @else
                                                                {{" : $fieldValue"}}
                                                            @endif
                                                        </span>
                                                </div>
                                            @endif
                                    @endif
                                @endforeach
                            @endif
                        @endforeach
                    @endif
                @endforeach
                <div class="col-3">
                    <button type="button" class="btn btn-primary btn-sm btnxsm" data-toggle="modal" data-target="#multiForm_popup" onclick="showSingleValue('{{$key}}' , '{{$valueKey}}', '{{@$workTypeDataId}}')"  id="view_form_btn">view/Edit</button>
                    <button  type="button" class="btn btnred btn-sm btnxsm" data-toggle="modal" data-target="#delete_popup" onclick="deleteSingleValue('{{$key}}', '{{$valueKey}}', '{{@$workTypeDataId}}')"  id="delete_form_btn">Delete</button>
                </div>
            </div>
        @endforeach
    </div> --}}
