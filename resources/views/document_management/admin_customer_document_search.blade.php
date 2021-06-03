

<style>
    .section_details{
        max-width: 1300px;
        margin: 0 auto;
        /* max-width: 100%;
        margin: 0;
        padding-bottom: 10px; */
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
  
  </style>
@php
// page for admin to view customer window
    // $count=0;
@endphp
@php
    $docs= count($docs)? $docs : "";
    if($docs)
    {
        $file=$docs;
        $total=count($file)-1;
    }
    else {
        $total=0;
    }
@endphp
  
<div class="table_bottom" id="tbl_docs">
    <input type="hidden" id="hdn_count" value="{{$total}}">
    <table>
        <thead>
            <th style="padding-left: 31px;">ATTACHMENT NAME</th>
            <th style="padding-left: 31px;">UPLOADED DATE & TIME</th>
            <th style="padding-left: 31px;"></th>
        </thead>
        <tbody id="add_result">
            @if(! $docs)
                @php
                    $total=0;
                @endphp
                <tr id="no_doc">
                    <td>
                        <h4 class="" style="margin-left:10px;">No documents found</h4>                                            
                    </td>
                    <td></td>
                    <td></td>
                </tr>
            @else
                @php
                    $count=$total;
                    $docs=collect($docs)->reverse()->toArray();
                @endphp
                    @foreach ($docs as $key => $item)
                            @php
                                $path=$item['filePath'];
                                $ext=explode('.',$path);
                                $ext=end($ext);
                                $name;
                                if(isset($item['suffix']))
                                {
                                    $suffix=$item['suffix'];
                                }
                                else {
                                    $suffix="";
                                }
                                if(isset($item['updatedName']) && $item['updatedName']!="")
                                {
                                    $name=$item['updatedName'].".".$ext;
                                }
                                else
                                {
                                    $name=$item['fileName'];
                                }
                                $downloadName=explode('.',$name);
                                $downloadName=$downloadName[0];
                                $name=$downloadName.(($suffix!="")? "-".$suffix.".".$ext : ".".$ext);
                                $downloadName=explode('.',$name);
                                $downloadName=$downloadName[0];
                                $add="&name=".$name;
                                
                            @endphp
                            <tr id="attach_{{$key}}">
                                <td style="padding-left:28px;">
                                    <div class="media">
                                        <span class="icon_bg">
                                            <i class="fa fa-file-o icon_white" aria-hidden="true"></i> 
                                        </span>
                                        <div class="media-body">
                                            <span class="upload_file_name" style="word-break: break-all;">
                                                {{$name}}
                                            </span>
                                            <span id="mail_{{$key}}">
                                                @if (@$item['customerViewed']!=1)
                                                    <span class="customer_status">
                                                        <span class="status_textsize">NEW</span>
                                                    </span>
                                                @endif
                                            </span>
                                        </div>
                                    </div>
                                </td>
                                <td>{{$item['uploadedAt']}}</td>
                                <td>
                                    <div class="action_icon">
                                        <a href="{{url('document/download?index='.$path.$add)}}" download="{{$downloadName}}">
                                            <button class="blue_btn attach_icons action-icon-download" data-toggle="tooltip" data-placement="bottom" data-container="body" data-original-title="Download">
                                                <i class="fa fa-cloud-download"></i>
                                            </button>
                                        </a>
                                        <button class="blue_btn attach_icons action-icon-view" data-toggle="tooltip" data-placement="bottom" data-container="body" data-original-title="View"
                                        onclick="view('{{$path}}')">
                                            <i class="fa fa-eye"></i>
                                        </button>
                                        <button class="blue_btn attach_icons action-icon-view" style="background-color: #ea5449 !important" data-toggle="tooltip" data-placement="bottom" data-container="body" data-original-title="Remove"
                                        onclick="removeAttechConfirm('{{$item['id']}}','{{$customer}}','{{$key}}')">
                                            <i class="fa fa-trash" aria-hidden="true"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @php
                            $count--;
                        @endphp
                    @endforeach
            @endif
        </tbody>    
    </table>
</div>

          
<script>



</script>
  
  