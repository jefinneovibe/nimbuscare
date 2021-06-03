@if($datas != null)
<label class="form_label bold" style="margin-bottm: 5px;">Select the files to be attached <span style="visibility:hidden">*</span></label>
    @foreach($datas as $k=> $data)
    <div class="col-12 custom-control custom-checkbox mb-3">
        <input class="custom-control-input"  type="checkbox" name="files[{{$data->filename}}]" value="{{$data->url}}"id="{{$data->url}}" style="display: none">
        <label class="custom-control-label"for="{{$data->url}}">{{$data->filename}}</label>
    </div>
    @endforeach
@else
    No files available
@endif
