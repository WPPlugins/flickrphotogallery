<?php if($atts['show_as'] == 'slideshow'){ ?> 
    <style type="text/css">
        div.FPG_flickrContainerSlide{
            max-width:<?php echo $atts['width']; ?>px;
            max-height:<?php echo floor(($atts['width']/3)*2); ?>px;
            border-color: <?php echo $atts['border_color']; ?>;
        }
        
            div.FPG_flickrContainerSlide ul.FPG_ulSlide{
                height:<?php echo $atts['width']; ?>px;
            }
            
                div.FPG_flickrContainerSlide ul.FPG_ulSlide li.FPG_imageContainerSlide{
                    width:<?php echo $atts['width']; ?>px;
                    height:<?php echo floor(($atts['width']/3)*2); ?>px;
                    position:relative;
                }
                
                    div.FPG_flickrContainerSlide ul.FPG_ulSlide li.FPG_imageContainerSlide a img{
                        min-width:<?php echo $atts['width']; ?>px;
                    }
    </style>  
<?php } else{ ?>
    <style>
        li.FPG_imageContainerList{ border-color: <?php echo $atts['border_color']; ?> !important; }   
    </style>
<?php } ?>