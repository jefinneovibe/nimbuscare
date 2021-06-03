// Add the following code if you want the name of the file appear on select
$(".custom-file-input").on("change", function() {
  var fileName = $(this).val().split("\\").pop();
  $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
});
$(window).on('load', function(){
    $( ".aed" ).trigger( "change" );
});
$('.aed').on('change', function(){
    var x=$(this).val();
    var res = x.replace(/[,]+/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    $(this).val(res);
});
$('.floatAmount').on('change',function(){
    $(this).rules("add", {
        floatAmount : true
    });
});
$.validator.addMethod(
  "amount",
  function(value, element) {
    regexp = "^[0-9]*$";
    value = value.replace(/,/g , '').trim();
    var re = new RegExp(regexp);
    if (value) {
        return re.test(value);
    } else {
        return true;
    }
  },
  "Please enter a valid digit."
);

$.validator.addMethod(
  "minimumAmountValue",
  function(value, element, params) {
    value = value.replace(/,/g , '').replace(/^0+$/g, "").trim();
    if (value) {
        var min = Math.min(value, params);
        if (params == min) {
            return true;
        } else{
            return false;
        }
    } else {
        return true;
    }
  },
  "Please check your input."
);

$.validator.addMethod(
    "floatAmount",
    function(value, element) {
      value = value.replace(/,/g , '').replace(/^0+$/g, "").trim();
      return /^-?\d*(\.\d+)?$/.test(value);
    },
    "Please enter a valid digit."
  );
  $.validator.addMethod(
      "percentageOnly",
      function(value, element) {
        if (value>=0 && value<=100) {
            return true;
        } else {
            return false;
        }
      },
      "Please enter a value in between 0 and 100."
    );
    $.validator.addMethod(
        "percentageOnlyFromOne",
        function(value, element) {
          if (value>=-1 && value<=101) {
              return true;
          } else {
              return false;
          }
        },
        "Please enter a value in between 0 and 100."
      );
$.validator.addMethod("customemail",
    function(value, element) {
        if (value.trim() != '') {
            return /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(value);
        } else {
            return true;
        }
    },
    "Please enter a valid email id. "
);

$.validator.addMethod("greaterOrEqualThan",
    function (value, element, param) {
          value = value.replace(/,/g , '').replace(/^0+$/g, "").trim();
          var $elemToCheck = $(param);
          return parseInt(value, 10) >= parseInt($elemToCheck.val(), 10);
    });

$.validator.addMethod("greaterThan",
    function (value, element, param) {
        value = value.replace(/,/g , '').replace(/^0+$/g, "").trim();
        var $elemToCheck = $(param);
        var targetVal = $elemToCheck.val();
        targetVal = targetVal.replace(/,/g , '').replace(/^0+$/g, "").trim();
        min = Math.min(value, targetVal);
        if (targetVal == min) {
            return true;
        } else{
            return false;
        }
    //return parseInt(value, 10) > parseInt(targetVal, 10);
});

$('.add_datepicker').each(function (fn, element){
    $(element).datepicker({dateFormat: 'dd/mm/yy', changeMonth: true, changeYear: true});
});


$.validator.addClassRules("percentageOnly", {
    percentageOnly: true
});
$.validator.addClassRules("percentageOnlyFromOne", {
    percentageOnlyFromOne: true
});
$.validator.addClassRules("numberOnly", {
    number: true
});

$.validator.addClassRules("amountOnly", {
    amount: true
});
$.validator.addClassRules("requiredOnly", {
    required: true
});
$.validator.addClassRules("emailField", {
    customemail: true
});

$.validator.addMethod("alphaNumSpace", function(value, element) {
    return this.optional(element) || /^[a-zA-Z\s]+$/i.test(value);
}, "Only alphabetical characters");
$.validator.addMethod("fileSize", function(value, element, param) {
    return  this.optional(element) || (element.files[0].size <= param);
}, "Please upload a file less than 2MB");

//for left collapsible window

$('#sidebarCollapse').on('click', function () {
  $('#sidebar, #content').toggleClass('active');
  $('.collapse.in').toggleClass('in');
  $('a[aria-expanded=true]').attr('aria-expanded', 'false');
});


// for timer to work

$(document).ready(function() {

  setInterval( function() {
      var hours = new Date().getHours();
      $(".hours").html(( hours < 10 ? "0" : "" ) + hours);
  }, 1000);
  setInterval( function() {
      var minutes = new Date().getMinutes();
      $(".min").html(( minutes < 10 ? "0" : "" ) + minutes);
  },1000);
  setInterval( function() {
      var seconds = new Date().getSeconds();
      $(".sec").html(( seconds < 10 ? "0" : "" ) + seconds);
  },1000);
});

//script for right side bar----------------------



function openRightMenu() {
document.getElementById("rightMenu").style.display = "block";
}

function closeRightMenu() {
document.getElementById("rightMenu").style.display = "none";
}





//-----------------------------for date picker-------

$(function() {
$( ".date" ).datepicker({
dateFormat : 'dd/mm/yy',
showOn: "both",
buttonImage: null,
buttonImageOnly: true,
buttonText: "",
changeMonth: true,
changeYear: true,
yearRange: "-100:+100"
});
});
/*



$(function() {
$( ".date" ).datepicker({
dateFormat : 'dd/mm/yy',
showOn: "both",
buttonImage: "b_calendar.png",
buttonImageOnly: true,
buttonText: "Select date",
changeMonth: true,
changeYear: true,
yearRange: "-100:+0"
});
});


*/
  // Add the following code if you want the name of the file appear on select
  $(".custom-file-input").on("change", function() {
    var fileName = $(this).val().split("\\").pop();
    $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
});

// To hide error span on select globally
$("select").on("change", function() {
    var valuee = $(this).val();
    var thisID = $(this).attr('id');
    if(valuee !='') {
        $("#"+thisID+'-error').hide();
    }
});


// to provide loader on buttons
$(document).ready(function() {
  $('.btnload').on('click', function() {
    var $this = $(this);
    var loadingText = '<i class="fa fa-circle-o-notch fa-spin"></i>';
    if ($(this).html() !== loadingText) {
      $this.data('original-text', $(this).html());
      $this.html(loadingText);
    }
    setTimeout(function() {
      $this.html($this.data('original-text'));
    }, 800);
  });
});



