$('.fieldName_hidden').each(function(index, element) {
    makeGeographWork(element.value);
});

function makeGeographWork(elemId) {
    $(window).load(function(){
        if($('#'+elemId+'withinUAE').prop('checked') != true && $('#'+elemId+'outsideUAE').prop('checked') != true) {
            $('#'+elemId+'emirateNameDiv').hide();
            $('#'+elemId+'countryNameDiv').hide();
        }

    $('#'+elemId+'withinUAE').click(function(){
    $('#'+elemId+'countryNameDiv').hide();
    $('#'+elemId+'countryName').find('option:eq(0)').prop('selected', true);
    $('#'+elemId+'countryNameHidden').val('');
    });

    $('#'+elemId+'outsideUAE').click(function(){
    var elemtemp = $('#'+elemId+'countryNameHidden').val();
    $('#'+elemId+'countryName').val(elemtemp).trigger('change');
    $('#'+elemId+'emirateName').val('').trigger('change');
    $('#'+elemId+'countryNameDiv').show();
    $('#'+elemId+'emirateNameDiv').hide();
    });
});
}


   //--------------------------------autochange of expiry date----------------------
   $(".issuanceDate").change( function () {
    var str = $(".issuanceDate").val();
    if( /^\d{2}\/\d{2}\/\d{4}$/i.test( str ) ) {
        var parts = str.split("/");
        var day = parts[0] && parseInt( parts[0], 10 );
        var month = parts[1] && parseInt( parts[1], 10 );
        var year = parts[2] && parseInt( parts[2], 10 );
        var duration = 1;
        if( day <= 31 && day >= 1 && month <= 12 && month >= 1 ) {
            var expiryDate = new Date( year, month - 1, day );
            expiryDate.setFullYear( expiryDate.getFullYear() + duration );
            var day = ( '0' + expiryDate.getDate() ).slice( -2 );
            var month = ( '0' + ( expiryDate.getMonth() + 1 ) ).slice( -2 );
            var year = expiryDate.getFullYear();
            if (day>1)
            {
                day = day-1;
                day = ( '0' + day ).slice( -2 );
            }
            else
            {
                month = month-1;
                if(month == 1 ||month == 3 ||month==5||month==7||month==8||month==10||month==12)
                {
                    day = 31;
                }
                else
                {
                    day = 30;
                }
                month = ( '0' + month ).slice( -2 );
            }
            $(".expiryDate").val( day + "/" + month + "/" + year );
        }
    }
});