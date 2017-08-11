<?php
/*******************************************************************************
 * This file contains the css declaration for the plugin widget                * 
 ******************************************************************************/
/*
    * If the type of view is "slideshow" add some css rules
    */
if($showAs == 'slideshow')
{
    ?> 
    <style type="text/css">
        div.FPG_widgetContainerSlide{
            max-width:<?php echo $width; ?>px;
            max-height:<?php echo floor(($width/3)*2); ?>px;
            border-color: <?php echo $borderColor; ?> !important;
        }
        div.FPG_widgetContainerSlide ul.FPG_slideUl{
            height:<?php echo $width; ?>px;
        }
        div.FPG_widgetContainerSlide ul.FPG_slideUl li.FPG_widgetImageContainerSlide{
            width:<?php echo $width; ?>px;
        }
        div.FPG_widgetContainerSlide ul.FPG_slideUl li.FPG_widgetImageContainerSlide a img{
            min-width:<?php echo $width; ?>px;
        }
    </style>  
    <?php
} else{
?> 
    <style>
        li.FPG_widgetImageContainerList{
            border-color: <?php echo $borderColor; ?> !important;
            
        }
    </style>
<?php } ?>