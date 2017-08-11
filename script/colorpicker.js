jQuery(document).ready(function($) {
    $('#colorpicker').hide();
    $('#colorpicker').farbtastic("#border_color");
    $("#border_color").click(function(){$('#colorpicker').slideToggle()});
  });


