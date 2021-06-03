    <style>
        .viewStatus{
            padding: 3px 2px 0px 2px;
            font-weight: 600;
            color: #ffffff;
        }
        </style>
    <body>
    <div class="wrapper">
        <div class="">
            @yield('content')
        </div>
    </div>
<style>
    #image_preview {
        height: 100%;
        width: auto;
        position: inherit;
    }
    #img_prview_area {
        position: absolute;
        /* width: auto; */
        height: 100%;
    }


</style>



    @stack('widgetScripts')
<script>
$('.selectpicker').selectpicker();
$('#multiForm_popup_content_spacing .aed').on('change', function(){
    var x=$(this).val();
    var res = x.replace(/[,]+/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    $(this).val(res);
});
</script>
