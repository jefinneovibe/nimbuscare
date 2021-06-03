


<style>
    .section_details{
        max-width: 1050px;
        margin: 0 auto;
        padding-bottom: 10px;
    }
    .section_details .card_header{
        padding: 15px 19px;
    }
        .section_half{
            width: 100%;
        }
        table {
        border-collapse: collapse;
        width: 100%;
        }
    th, tr {
    font-size: 11px;
    font-weight: 600;
    color: #707477;     
    padding: 4px 15px;
    text-align: left;
    border-bottom: 1px solid #ddd;
    }
    td{
        padding: 9px;
        font-size: 13px;
        text-align: left;
    }
    .upload_scroll {
        overflow: auto;
        height: 371px;
    }
    .section_details .card_header{
        border-bottom: none !important;
    }
    .custom_row{
        border-bottom:none;
        padding: 0;
        margin: 0;
        line-height: 0; 
        color: #cc3766;
    }
</style>
    @php
        // page for customer search .........
    @endphp
    <table>
        <thead>
            <th></th>
            <th></th>
        </thead>
        <tbody>
            @if (count($docs))
                @foreach ($docs as $key => $item)
                    @php
                        // $ext=explode('.',$path);
                        // $ext=end($ext);
                        // $name="";
                        // if(isset($item->suffix))
                        // {
                        //     $suffix=$item->suffix;
                        // }
                        // else {
                        //     $suffix="";
                        // }
                        // if(isset($item->updatedName) && $item->updatedName!="")
                        // {
                        //     $name=$item->updatedName.".".$ext;
                        // }
                        // else
                        // {
                        //     $name=$item->fileName;
                        // }
                        // $downloadName=explode('.',$name);
                        // $downloadName=$downloadName[0];
                        // $name=$downloadName.(($suffix!="")? "-".$suffix.".".$ext : ".".$ext);
                        // $downloadName=explode('.',$name);
                        // $downloadName=$downloadName[0];
                        // $add="&name=".$name;

                        $path=$item->filePath;
                        $add="&name=".$item->updatedFullName;
                        // dd($add, $path, $name, $downloadName);
                    @endphp
                    <tr id="attach_{{$key}}">
                        <td style="padding-left:28px;">
                            <div class="media">
                                <span class="icon_bg">
                                    <i class="fa fa-file-o icon_white" aria-hidden="true"></i> 
                                </span>
                                <div class="media-body">
                                    <span class="upload_file_name" style="word-break: break-all;">
                                        {{$item->updatedFullName}}
                                    </span>
                                    <span id="{{$key}}">
                                        @if (@$item->customerViewed==0)
                                            <span class="customer_status">
                                                <span class="status_textsize">NEW</span>
                                            </span>
                                        @endif
                                    </span>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="action_icon">
                                <a href="{{url('customer-document/download?index='.$path.$add)}}">
                                    <button class="blue_btn attach_icons action-icon-download" data-toggle="tooltip" data-placement="bottom" data-container="body" data-original-title="Download"
                                    onclick="customerViewed('{{$key}}', '{{(string)$item->_id}}')">
                                        <i class="fa fa-cloud-download"></i>
                                    </button>
                                </a>
                                <button class="blue_btn attach_icons action-icon-view" data-toggle="tooltip" data-placement="bottom" data-container="body" data-original-title="View"
                                onclick="view('{{$path}}', '{{$key}}', '{{(string)$item->_id}}')">
                                    <i class="fa fa-eye"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                @endforeach
            @else
                <h4 class="card_header" style="margin-left:18px;">No documents found</h4>
            @endif
        </tbody>    
    </table>
<script>
</script>

