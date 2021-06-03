
 @if(isset($config['label']) && @$config['label'] != '')
    <div class="row">
        <div class="col-12"><label><b class="titles">{{$config['label']}}</b></label></div>
    </div>
@endif
<?php @eval("\$str = \"{$config['value']}\";"); ?>
@if(isset($str) && @$str != '')
    <div class="row">
        <div class="col-3">
            <label class="titles ">{{@$str}}</label>
        </div>
    </div>
@endif
@if(!empty($config['statement']))
    <div class="row">
        <div class="col-12">
            <div class="disclaimer red spacing ">
                <p class="text-justify">{!! $config['statement'] !!}</p>
            </div>
        </div>
    </div>
@endif



{{-- <tr class="form-group">
    @if(isset($config['label']) && @$config['label'] != '')
        <td class="qus_title" style="vertical-align: top;"><label><b class="titles">{{$config['label']}}</b></label></td>
    @endif
        <!-- @if($config['label'])<td class="colon" style="vertical-align: top;">:</td> @else <td class="colon"></td> @endif -->
</tr>
<tr>
    <td><label class="titles ">{{@$str}}</label>
        @if(!empty($config['statement']))
            <div class="disclaimer red spacing ">
                <p class="text-justify">{{$config['statement']}}</p>
            </div>
        @endif
    </td>
</tr> --}}
