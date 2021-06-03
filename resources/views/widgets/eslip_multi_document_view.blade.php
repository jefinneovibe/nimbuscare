
@if (!empty($files))
    <label><b class="titles">{{@$config['label']}}</b></label>
    <div class="row">
        @foreach ($files as $file)
            @if (isset($file['url']) && $file['url'] != '' && $file['upload_type'] == @$config['uploadType'] )
                <div class="col-3 flex_label">
                    <label class="titles" style="word-break: break-all;" for="filename">{{$file['file_name']}}</label>
                    <a target="_blank" class="btn file_uploadBtn btn-sm btn-primary" href="{{$file['url']}}">view</a>
                </div>
            @endif
        @endforeach
    </div>
@endif
