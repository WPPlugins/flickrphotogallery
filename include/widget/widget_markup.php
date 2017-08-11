<?php
/*******************************************************************************
 * This file contains the markup used to render the widget in frontend         * 
 ******************************************************************************/
//INCLUDE THE CSS FILE
include_once dirname(__FILE__).'/widget_style.php';
?>
<h3 class="FPG_widgetTitle"><?php echo $instance['title']; ?></h3>
<div class="FPG_widgetContainer<?php echo $showAs=='list'?'List':'Slide'; ?>">
    <ul class="<?php echo $showAs=='list'?'FPG_listUl':'FPG_slideUl'; ?>">
<?php foreach ((array)$images['photos']['photo'] as $image){ ?>
        <li class="FPG_widgetImageContainer<?php echo $showAs=='list'?'List':'Slide'; ?>">
    <?php if($useFancybox){ ?>
            <a title="<?php echo $image['title'];?>" 
               rel="FPG_flickrFancybox-<?php echo $this->id;?>" 
               class="FPG_fancybox"
               href="<?php echo $FPG_widget->buildPhotoURL($image, 'medium_640');?>">
    <?php } else{ ?>
            <a title="<?php echo $image['title'];?>" 
               href="http://www.flickr.com/photos/<?php echo $image['owner'];?>/<?php echo $image['id'];?>"> 
    <?php } ?>
                <img src="<?php echo $FPG_widget->buildPhotoURL($image, ($showAs == 'list'?'square':$imageDim));?>" alt="<?php echo $image['title'];?>" />
            </a>
        </li>
<?php } ?>
    </ul>
</div>