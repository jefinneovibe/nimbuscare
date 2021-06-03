
    <div class="col-12">
        <div class="form-group">
            <label><b class="titles label_{{@$config['id']}}">{{@$config['label']?:'Claims History :'}} <span>*</span> </b></label>
        </div>
    </div>
    <div class="{{@$config['field_class']?:'col-12'}} child_space form-group bmd-form-group">
        <table @if (isset($config['style']['tableWidth']))
                style="width:{{@$config['style']['tableWidth']?:'100%'}};"
        @endif class="claimhistory">
            <thead>
                <tr>
                    <th style="width:10%;"><b class="titles">Year</b></th>
                    @foreach ($config['columns'] as $item)
                        <th style="width:{{@$item['columnWidth']?:'40px'}}"><b class="titles">{{$item['label']}}</b></th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                 <?php
                $i=0;
                for ($i=1; $i<4; $i++) {
                    $class = '';
                    ?>
                    <tr>
                        <td> {{$i}} &nbsp;
                            <input type="hidden" name="claimsHistory[{{$i}}][year]" value="year {{$i}}">
                            @if ($i == 1)
                            <?php $class = 'requiredClaimTab'; ?>
                                <i data-toggle="tooltip" data-placement="top" title="Most Recent" data-container="body" class="fa fa-info red"></i>
                            @endif
                        </td>
                        @foreach ($config['columns'] as $item)
                            <td>
                                @if (@$item['aed'])
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">AED</span>
                                        </div>
                                        <input type="text" name="claimsHistory[{{$i}}][{{$item['fieldname']}}]" @if (@$value[$i]['amount'])
                                            value="{{@$value[$i]['amount']}}" @else value="{{@$value[$i][$item['fieldname']]}}"
                                        @endif class="form-control aed claimHisTable_amount {{@$class}}" placeholder="Enter {{@$item['label']}}">
                                    </div>
                                @else
                                    <input type="text" name="claimsHistory[{{$i}}][{{$item['fieldname']}}]" @if (@$value[$i]['description'])
                                        value="{{@$value[$i]['description']}}" @else value="{{@$value[$i][$item['fieldname']]}}"
                                    @endif  class="form-control {{@$class}}" placeholder="Enter {{@$item['label']}}">
                                @endif
                            </td>
                        @endforeach
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    <style>
    .ui-widget-content[role=tooltip]{
        max-width: 150px;
        text-align: center;
        padding: 2px 8px;
    }
    </style>
@push('widgetScripts')
    <script>
        $(window).load(function(){
            $(".claimHisTable_amount").each(function() {
                $(this).rules("add", {
                    // amount : "^[0-9]*$"
                    amount : true
                });
                $(this).rules("add", {
                    messages: {
                        amount : 'Enter digits only.'
                    }
                });
            });
            $(".requiredClaimTab").each(function() {
                $(this).rules("add", {
                    required : true
                });
                $(this).rules("add", {
                    messages: {
                        required : 'Please enter this field.'
                    }
                });
            });
        });
    </script>
@endpush
