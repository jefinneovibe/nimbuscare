
<table style="width: 100%">
    <tr>
        <td class="name"><label class="form_label">Uploaded Signs <span style="visibility: hidden">*</span> </label></td>
        <td width="20">:</td>
        <td>
            @if(count(@$deliveryStatus)>0)
		        <?php $count_num =1; ?>
                @foreach(@$deliveryStatus as $status)
                        @if((isset($status['upload_sign'])&& $status['upload_sign']!=""   && !isset($status['status']))
                        || (isset($status['upload_sign']) && $status['upload_sign']!=""   && isset($status['status']) && $status['status']=="Delivered"))
                        <a class="signature_sec" href="{{$status['upload_sign']}}" target="_blank">Sign{{' '.$count_num}}</a>
				        <?php  $count_num++;?>
                    @endif
                @endforeach
            @endif
        </td>
    </tr>
</table>

<style>
    .signature_sec{
        padding: 4px 12px;
        border-radius: 2px;
        display: inline-block;
        border: 1px solid #0262e2;
        color: #0262e2;
        font-size: 13px;
        font-weight: 500;
        margin-bottom: 5px;
        margin-right: 4px;
        float: left;
    }
    .signature_sec:hover{
        color: #0262e2;
    }
</style>














