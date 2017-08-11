jQuery(document).ready(function($){                            
    var stream = $('#stream').val();
    //SHOW ONLY NECESSARY FIELDS
    switch(stream){
        case 'public':
            $('#flickr_id').parentsUntil($('tbody')).hide();
            $('#photoset_id').parentsUntil($('tbody')).hide();
            break;
        case 'user':
            $('#flickr_id').parentsUntil($('tbody')).show();
            $('#photoset_id').parentsUntil($('tbody')).hide();
            break;
        case 'photoset':
            $('#flickr_id').parentsUntil($('tbody')).show();
            $('#photoset_id').parentsUntil($('tbody')).show();
            break;
        case 'group':
            $('#flickr_id').parentsUntil($('tbody')).show();
            $('#photoset_id').parentsUntil($('tbody')).hide();
            break;
    }   
    var show_as = $('#show_as').val();
    if (show_as == 'list'){ 
        $('#width').parentsUntil($('tbody')).hide();
    }else{
        $('#width').parentsUntil($('tbody')).show();
    }
    
    /***************************************************************************
     *this function check if the passed field is visible,                      *
     *if not, shows it with a fadeIn effect                                    *
     **************************************************************************/
    function setVisible(inField){
        if(inField.is(':visible')){
            return;
        }
        inField.parentsUntil($('tbody')).fadeIn();
    }
    
    /***************************************************************************
     *this function check if the passed field is hidden ,                      *
     *if not, hide it with a fadeOut effect                                    *
     **************************************************************************/
    function setHidden(inField){
        if(inField.is(':hidden')){
            return;
        }
        inField.parentsUntil($('tbody')).fadeOut(); 
    }
    
    /***************************************************************************
     *this function check which fields to show beetween "flickr_id"            *
     *and "photoset_id" when you change the "stream" selection                 *
     **************************************************************************/
    function showIdSettingsOnChange()
    {
        //declare control variable
        var checkType = $('#stream').val();
        //if the select value is user or group
        //show the id settings
        switch(checkType){
            case 'public':
                setHidden($('#flickr_id'));
                setHidden($('#photoset_id'));
                break;
            case 'user':
                setVisible($('#flickr_id'));
                setHidden($('#photoset_id'));
                break;
            case 'photoset':
                setVisible($('#flickr_id'));
                setVisible($('#photoset_id'));
                break;
            case 'group':
                setVisible($('#flickr_id'));
                setHidden($('#photoset_id'));
                break;
        }
        if(checkType.match(/(user|group)/))
        {
            $('#flickr_id').parentsUntil($('tbody')).fadeIn();
            $('label[for=flickr_id]').text(checkType == 'user' ? "Your Flickr User Id:" : "Your Flickr Group Id:");
        }
        else if(checkType == 'photoset')
        {
            setVisible($('#flickr_id'));
            $('label[for=flickr_id]').text("Your Flickr User Id:");
            setVisible($('#photoset_id'));
        }
    };
    
    /***************************************************************************
     *this function check if the user wants to show the gallery                *
     *as a slideshow, in this case shows the "width" field                     *
     **************************************************************************/
    function showSlideshowWidth()
    {
        var checkShowAs = $('#show_as').val();
        if(checkShowAs =='slideshow')
        {
            setVisible($('#width'));
        }else{
            setHidden($('#width'))
        }
    }
    
    
    $('#show_as').change(showSlideshowWidth);
    $('#stream').change(showIdSettingsOnChange);

})