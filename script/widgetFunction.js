jQuery(document).ready(function($){
    slideshows = $('.FPG_widgetContainerSlide');
    slideshows.each(function(){
        var images = $("ul.FPG_slideUl li",this);
        var numImages = images.length;
        var imageWidth = images.outerWidth(true);
        var totalWidth = numImages * imageWidth;
        var stopPosition = (imageWidth - totalWidth);
        var wrapper = $('ul.FPG_slideUl',this);
        wrapper.width(totalWidth);
        setInterval(slideNext, 3000);
        function slideNext()
        {
           if(wrapper.position().left > stopPosition)
           {
              wrapper.animate({left: '-='+imageWidth+'px'});
           }
           else
           {
              wrapper.animate({left: 0});
              return false;
           };

        };
    })
})