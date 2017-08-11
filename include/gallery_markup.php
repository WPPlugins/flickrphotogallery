<h3 class="FPG_title"><?php echo $atts['caption'];?></h3>
<div class="FPG_flickrContainer<?php echo $show_as_class; ?>">
    <ul class="FPG_ul<?php echo $show_as_class;?>">
<?php foreach ((array)$images['photos']['photo'] as $image){ ?>
        <li class="FPG_imageContainer<?php echo $show_as_class;?>">
            
            <?php if($atts['use_fancybox']){ ?>
            
            <a title="<?php echo $image['title'];?>" rel="FPG_flickrFancybox-<?php echo $this->FPG_shortcodeId;?>" class="FPG_fancybox" href="<?php echo $f->buildPhotoURL($image, 'medium_640');?>">
            
            <?php } else{ ?>
            
            <a title="<?php echo $image['title'];?>" href="http://www.flickr.com/photos/<?php echo $image['owner'];?>/<?php echo $image['id'];?>"> 
            
            <?php } ?>
                
                <img src="<?php echo $f->buildPhotoURL($image, $image_width); ?>" />
            </a>
            <span class="FPG_descriptionContainer"><?php echo $image['title'];?></span>
        </li>
        <?php } ?>
    </ul>
</div>



