<div class="col-{{@$config['style']['col_width']?:6}}">
<div class="form_group">
        <div>
        <label class="form_label">{{$config['label']}}</label>
        <div class="custom_upload custom_upload_new" id="file_{{$config['fieldName']}}" >
            <input type="file" name="{{$config['fieldName']}}" id="{{$config['fieldName']}}" accept='image/*'>
            <p>Drag your files or click here.</p>
        </div>
        <div class="view_img">
            <img class="custom-preview banner_preview_new" id="{{$config['fieldName']}}_preview" onclick="viewLogo(this)">
            <button style="display:none;" id="del-{{$config['fieldName']}}" type="button" class="delete_circle"  onclick="imageDelete('{{$config['fieldName']}}')"><i class="far fa-trash-alt"></i></button>
       <span id="{{$config['fieldName']}}-error-val"></span>
        </div>
    </div> 
</div>
</div>

@push('scripts')
<script>
    /**
         * file upload functions
         * */
         $(window).ready(function(){
            $('#'+'{{$config['fieldName']}}').on('change', function () {
            var width;
            var height;
            if (this.files && this.files[0]) {
                var file = this.files[0];
                var tmpImg = new Image();
                tmpImg.src=window.URL.createObjectURL( file );
                $('#'+'{{$config['fieldName']}}'+'_preview').attr('src', window.URL.createObjectURL( file ));
                tmpImg.onload = function() {
                    width = tmpImg.naturalWidth;
                    height = tmpImg.naturalHeight;
                    size = Math.round(file.size/1024); //In KB
                    var requiredWidth = "{{@$config['validation']['maxWidth']?:0}}";
                    var requiredHeight = '{{@$config['validation']['maxHeight']?:0}}';
                    var requiredSize = '{{@$config['validation']['maxSize']?:0}}';
                    widthToCheck = requiredWidth > 0 ? requiredWidth : width;
                    heightToCheck = requiredHeight > 0 ? requiredHeight : height;
                    sizeToCheck = requiredSize > 0 ? requiredSize : size;
                    if(width == widthToCheck && height == heightToCheck && size <= sizeToCheck){
                        $('#file_'+'{{$config['fieldName']}}').hide();
                        $('#'+'{{$config['fieldName']}}'+'-error-val').hide();
                        $('#'+'{{$config['fieldName']}}'+'_preview').show();
                        $('#del-'+'{{$config['fieldName']}}').show();
                    }else{
                        $('#'+'{{$config['fieldName']}}'+'-error-val').html('Image must be of preferred size.');
                        $('#'+'{{$config['fieldName']}}'+'-error-val').show();
                        $('#file_'+'{{$config['fieldName']}}').hide();
                        $('#'+'{{$config['fieldName']}}'+'_preview').show();
                        $('#del-'+'{{$config['fieldName']}}').show();
                    }
                };
            }
        });


         })
        
        function imageDelete(id)
        {
            $('#'+id+'-error-val').hide();
            $('#php-error_'+id).hide();
            $('#submit').removeAttr('disabled');
            $('#save').removeAttr('disabled');
            $('#'+id).val('');
            $('#'+id+'_preview').hide();
            $('#del-'+id).hide();
            $('#file_'+id).show();
            $('#test_'+id).val('');
        }
        function viewLogo(obj)
        {
            var id = obj.id;
        }
</script>
@endpush