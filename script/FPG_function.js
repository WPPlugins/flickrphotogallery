jQuery(document).ready(function($){

    $('.FPG_imageContainerList, .FPG_imageContainerSlide').hover(function(){
        $(this).find('.FPG_descriptionContainer').stop().animate({bottom: '0'});
    }, function(){
        $(this).find('.FPG_descriptionContainer').stop().animate({bottom: '-25px'});
    });
        $('a.FPG_fancybox').fancybox({
		'transitionIn'	:	'elastic',
		'transitionOut'	:	'elastic',
                'easingIn'      :       'easeOutBack',
                'easingOut'     :       'swing',
		'speedIn'		:	600, 
		'speedOut'		:	200, 
		'overlayShow'	:	true,
                'titleShow'     :       true,
                'titlePosition' :       'over'
	});
        
    slideshows = $('.FPG_flickrContainerSlide');
            console.log(slideshows);
    slideshows.each(function(){
        var images = $("ul.FPG_ulSlide li.FPG_imageContainerSlide",this);
        console.log(images);
        var numImages = images.length;
        var imageWidth = images.outerWidth(true);
        var totalWidth = numImages * imageWidth;
        var stopPosition = (imageWidth - totalWidth);
        var wrapper = $('ul.FPG_ulSlide',this);
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
});


