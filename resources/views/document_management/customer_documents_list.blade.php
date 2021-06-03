

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
@endphp
@php
    $role= session('role');
    if($role== 'Agent' || $role== 'Coordinator') {
        $permission= 'disabled';
    } else {
        $permission="";
    }
    $customerSession=session('customer_view');
    if(!isset($customerSession)) {
        $customerSession="";
    }
    if($docs) {
        $total=count($docs)-1;
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
            @if(! count($docs))
                @php
                    $total=0;
                @endphp
                <tr>
                    <td>
                        <h4 class="" style="margin-left:10px;">No documents found</h4>
                    </td>
                    <td></td>
                    <td></td>
                </tr>
            @else
                @foreach ($docs as $key => $item)
                    @php
                        $path=$item->filePath;
                        $add="&name=".$item->updatedFullName;
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
                        <td>{{$item->uploadedAt}}</td>
                        <td>
                            <div class="action_icon">
                                <button class="blue_btn attach_icons action-icon-download" data-toggle="tooltip" data-placement="bottom" data-container="body"
                                data-original-title="Download" onclick="downloadAttachment('{{$path}}', '{{$add}}')">
                                    <i class="fa fa-cloud-download"></i>
                                </button>
                                <button class="blue_btn attach_icons action-icon-view" data-toggle="tooltip" data-placement="bottom" data-container="body" data-original-title="View"
                                onclick="view('{{$path}}')">
                                    <i class="fa fa-eye"></i>
                                </button>
                                @if ($permission != 'disabled')
                                    <button class="blue_btn attach_icons action-icon-view" style="background-color: #ea5449 !important" data-toggle="tooltip" data-placement="bottom" data-container="body" data-original-title="Remove"
                                    onclick="removeAttechConfirm('{{(string)$item->_id}}','{{$customer}}','{{$key}}')">
                                        <i class="fa fa-trash" aria-hidden="true"></i>
                                    </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
</div>
<script>
</script>

