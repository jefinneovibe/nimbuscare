<div class="col-{{@$config['style']['col_width']?:6}} inputDnD">
        <div class="form-group">
            <label class="titles" for="inputFile">{{ucfirst($config['label'])}} @if((!isset($config['notRequired']) && @$config['notRequired']!=true)) <span>*</span> @endif
              @if(@$value['url'])
                <a target="_blank" href="{{@$value['url']}}">
                <i class="fa fa-file"></i>
                </a>
              @endif
              @if(@$config['hasTemplate'] && @$config['templateUrl'])
                <a style="margin-left:10px" target="_blank" href="{{@$config['templateUrl']}}">
                <i title="Download Template" class="fa fa-download"></i>
                </a>
              @endif
              <button id="delBtn_{{@$config['id']}}" onclick="deleteImageUrl('{{@$config['id']}}', this)" style="float: right; display:none; " type="button" class="btn btn-outline-secondary btn-sm red">
                <i class="fa fa-trash-o" aria-hidden="true"></i>
              </button>

            </label>
            @if(@$value['url'])
            <div class="hiddenValues">
            <input type="hidden" name="{{@$config['fieldName']}}[url]"  value="{{@$value['url']}}" >
            <input type="hidden" name="{{@$config['fieldName']}}[fieldName]"  value="{{@$value['fieldName']}}">
            <input type="hidden" name="{{@$config['fieldName']}}[file_name]"  value="{{@$value['file_name']}}">
            <input type="hidden" name="{{@$config['fieldName']}}[upload_type]"  value="{{@$value['upload_type']}}">
            </div>
            @endif


            {{-- <input type="file" id="{{@$config['id']}}" class="@if(@$value['url']) removeRequired @endif form-control-file text-primary font-weight-bold"  name="documents[{{@$config['label']}}][{{$config['fieldName']}}]"  value="{{@$value['url']}}" placeholder="{{$config['placeHolder']}}"  onchange="readUrl(this)" data-title=" + Upload your file"> --}}

             <div class="custom-file mb-3">
                <input type="file" class="custom-file-input {{@$config['class']}} @if(@$value['url']) removeRequired @endif"  id="{{@$config['id']}}"  name="documents[{{@$config['label']}}][{{$config['fieldName']}}]"  value="{{@$value['url']}}" placeholder="{{$config['placeHolder']}}"  onchange="readUrl(this)" data-title=" + Upload your file">
                <label class="custom-file-label" id="label_{{@$config['id']}}" for="{{@$config['id']}}">+ Upload your file</label>
            </div>

        </div>
    </div>
@push('widgetScripts')
<script>
$(window).load(function(){
    $('.removeRequired').each(function(){
        $(this).rules('remove', 'required');
    });
});

//for file upload
function readUrl(input) {

  if (input.files && input.files[0]) {
    let reader = new FileReader();
    reader.onload = (e) => {
      let imgData = e.target.result;
      let imgName = input.files[0].name;
      input.setAttribute("data-title", imgName);
    }
    reader.readAsDataURL(input.files[0]);
    $('#'+input.id+'-error').hide();
    $("#delBtn_" +input.id ).show();
  }
   $(this).attr("value", "");
}
  function deleteImageUrl(imgId, t) {
    $("#"+imgId).val("");
    var imgName = ' + Upload your file';
    $("#"+imgId).attr("data-title", imgName);
    $("#label_"+imgId).text(imgName);
    $(t).hide();
  }
</script>
@endpush
