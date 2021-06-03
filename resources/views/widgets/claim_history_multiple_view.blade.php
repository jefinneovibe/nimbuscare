@if(!empty(@$formValues['eQuestionnaire']['policyDetails']['claimsHistory']))
    <?php $selectedType = @$formValues['eQuestionnaire']['policyDetails']['claimsHistory']['type'] ?>
    @if($selectedType == 'seperateData')
        <?php $loopFor = 2 ?>
    @else
        <?php $loopFor = 1 ?>
    @endif

    @if($selectedType != 'seperateData')
        <div class="row">
            <div class="col-12  form-group">
                <label><b class="titles">{{@$config['label'] ." ". @$config['col_titles'][$selectedType]}}</b></label>
                {{-- <label><b class="titles">{{@$config['col_titles'][$selectedType]}}</b></label> --}}
            </div>
            <div class="col-12 form-group">
                <table @if (isset($config['style']['tableWidth']))
                    style="width:{{@$config['style']['tableWidth']?:'100%'}};"
                @endif class="claimhistorydata">
                <thead>
                    <th style="width: 10%;"><label class="titles">Year</label></th>
                @if (@$config['type_col'])
                    <th style="width:{{@$item['columnWidth']?:'40px'}}"><label class="titles">Type</label></th>
                @endif
                @if (isset($config['columns'][$selectedType]))
                        @foreach (@$config['columns'][$selectedType] as $item)
                            <th style="width:{{@$item['columnWidth']?:'40px'}}"><label class="titles">{{$item['label']}}</label></th>
                        @endforeach
                @endif
                </thead>
                <tbody>
                    @foreach(@$formValues['eQuestionnaire']['policyDetails']['claimsHistory'] as $k=> $claimHistory)
                    @if(is_array($claimHistory))
                    <tr>
                        <td>{{$k}} &nbsp
                        @if($loop->iteration == 2)
                            (Most Recent)
                        @endif
                        </td>
                        @if (@$config['type_col'])
                        <td>{{@$claimHistory['type']?:'--'}}</td>
                        @endif
                            @if (isset($config['columns'][$selectedType]))
                                @foreach (@$config['columns'][$selectedType] as $item1)
                                    <td><p>{{@$claimHistory[$item1['fieldname']]?:'--'}}</p></td>
                                @endforeach
                            @endif
                    </tr>
                    @endif
                    @endforeach
                </tbody>
                </table>
            </div>
        </div>
    @else
        <div class="row">
            <div class="col-12 form-group">
                <label><b class="titles">{{@$config['label']}} Business interruption coverages</b></label>
                {{-- <label><b class="titles">Business interruption coverages</b></label> --}}
            </div>
            <div class="col-12 form-group">
                <table @if (isset($config['style']['tableWidth']))
                    style="width:{{@$config['style']['tableWidth']?:'100%'}};"
                @endif class="claimhistorydata">
                <thead>
                    <th style="width: 10%;"><label class="titles">Year</label></th>
                @if (@$config['type_col'])
                    <th style="width:{{@$item['columnWidth']?:'40px'}}"><label class="titles">Type</label></th>
                @endif
                @foreach (@$config['columns']['combinedData'] as $item)
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
                                @if (@$config['type_col'])
                                    <td>{{@$claimHistory['type']?:'--'}}</td>
                                @endif
                            @foreach ($config['columns']['combinedData'] as $item1)
                                <td><p>{{@$claimHistory[$item1['fieldname']]?:'--'}}</p></td>
                            @endforeach
                            </tr>
                        @endif
                    @endforeach
                </tbody>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-12 form-group">
                <label><b class="titles">{{@$config['label'] ." ". @$config['col_titles']['onlyFirePerils']}}</b></label>
                {{-- <label><b class="titles">{{@$config['col_titles']['onlyFirePerils']}}</b></label> --}}
            </div>
            <div class="col-12 form-group">
                <table @if (isset($config['style']['tableWidth']))
                    style="width:{{@$config['style']['tableWidth']?:'100%'}};"
                @endif class="claimhistorydata">
                <thead>
                    <th style="width: 10%;"><label class="titles">Year</label></th>
                @if (@$config['type_col'])
                    <th style="width:{{@$item['columnWidth']?:'40px'}}"><label class="titles">Type</label></th>
                @endif
                @foreach (@$config['columns']['onlyFirePerils'] as $item)
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
                        @if (@$config['type_col'])
                        <td>{{@$claimHistory['type']?:'--'}}</td>
                        @endif
                    @foreach ($config['columns']['onlyFirePerils'] as $item1)
                    <td><p>{{@$claimHistory[$item1['fieldname']]?:'--'}}</p></td>
                    @endforeach
                    </tr>
                    @endif
                    @endforeach
                </tbody>
                </table>
            </div>
        </div>
    @endif
@endif
