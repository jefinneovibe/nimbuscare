
<tr class="form-group">
    <td class="qus_title" style="vertical-align: top;"><label><b class="titles">{{$config['label']}}</b></label></td>
        @if($config['label'])<td class="colon" style="vertical-align: top;">:</td> @else <td class="colon"></td> @endif
            <?php @eval("\$str = \"{$config['value']}\";"); ?>
            <?php @eval("\$str2 = \"{$config['nonAdminValue']}\";"); ?>
            <?php @eval("\$status = \"{$config['valueStatus']}\";"); ?>
            <td>
        @if(@$status == 'admin')
            <label class="titles">{{@$str?:'NA'}}</label>
        @elseif(@$status == 'nonadmin')
            <label class="titles">{{@$str2?:'NA'}}</label>
        @elseif(@$status == 'both')
            <label class="titles">{{@$str?:'NA'}} </label>
            <label class="titles">{{@$str2?"$str2":'NA'}}</label>
        @endif
    </td>
</tr>
