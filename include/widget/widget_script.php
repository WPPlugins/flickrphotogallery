<?php
/*******************************************************************************
 * This file contains the necessary script for widget admin form               *
 ******************************************************************************/
?>
<script type="text/javascript">
jQuery(document).ready(function($){
    $('#<?php echo $this->id;?>-FPG_colorpicker').hide();
    $('#<?php echo $this->id;?>-FPG_colorpicker').farbtastic("#<?php echo $this->get_field_id('border_color');?>");
    $("#<?php echo $this->get_field_id('border_color');?>").click(function(){$('#<?php echo $this->id;?>-FPG_colorpicker').slideToggle()});
    function showIdSettingsOnChange()
    {
        $('#<?php echo $this->id;?>idRow, #<?php echo $this->id;?>photosetRow').hide();
        //declare control variable
        var checkType = $('#<?php echo $this->get_field_id('stream');?>').val();
        //if the select value is user or group
        //show the id settings
        if(checkType.match(/(user|group)/))
        {
            $('#<?php echo $this->id;?>idRow').show();
            $('#<?php echo $this->id;?>idLabel').text(checkType == 'user' ? "Your Flickr User Id:" : "Your Flickr Group Id:");
        }
        else if(checkType == 'photoset')
        {
            $('#<?php echo $this->id;?>idRow').show();
            $('#<?php echo $this->id;?>idLabel').text("Your Flickr User Id:");
            $('#<?php echo $this->id;?>photosetRow').show();
        }
    };
    
    function showSlideshowWidth()
    {
        $('#<?php echo $this->id;?>widthRow').hide();
        var checkShowAs = $('#<?php echo $this->get_field_id('show_as');?>').val();
        if(checkShowAs =='slideshow')
        {
            $('#<?php echo $this->id;?>widthRow').show();
        }
    }
    showSlideshowWidth();
    showIdSettingsOnChange();    
    $('#<?php echo $this->get_field_id('show_as');?>').change(showSlideshowWidth);
    $('#<?php echo $this->get_field_id('stream');?>').change(showIdSettingsOnChange);

                    
                    
    $('#<?php echo $this->id;?>findMyIdWidget').click(function(){
       //declare a control variable
       var checkType = $('#<?php echo $this->get_field_id('stream');?>').val();
       //prompt for flickr url for user or group
       //depending on what the user choose
       var x = prompt(checkType.match(/(user|photoset)/) ? 'Enter the URL of your flickr account' : 'Enter the URL of your flickr group', 
                      checkType.match(/(user|photoset)/) ? 'http://flickr.com/photos/your_username/' : 'http://flickr.com/groups/your_group/');
       if(!x) return false;
       var url = "http://api.flickr.com/services/rest/?"+
                "method="+(checkType.match(/(user|photoset)/) ? "flickr.urls.lookupUser&" : "flickr.urls.lookupGroup&")+
                "api_key=353077acfc6e1a37787fedb753efeaba&"+
                "format=json&"+
                "jsoncallback=?&"+
                "url="+x;
       $.getJSON(url, function(result){
           if (result.stat != 'ok')
           {
               alert('Problems occurred retrieving your id, please try again');
               return false
           }
           $('#<?php echo $this->get_field_id('flickr_id');?>').val(checkType.match(/(user|photoset)/) ? result.user.id : result.group.id);
       });
    });
})
</script>