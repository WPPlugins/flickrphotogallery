jQuery(document).ready(function($){
    $('a.FPG_find_id').live('click',function(){
        //declare a control variable
        var checkType = $('#stream').val();      
        if(checkType == 'public'){
            return false;
        }
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
            $('#flickr_id').val(checkType.match(/(user|photoset)/) ? result.user.id : result.group.id);
        });
    })
})

