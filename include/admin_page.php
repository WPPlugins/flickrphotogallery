<div class="wrap">
    
    <div id="icon-options-general" class="icon32"></div>
    
    <h2><?php _e('FlickrPhotogallery Settings', 'Flickrphotogallery'); ?></h2>
    
    <?php settings_errors(); ?>
    
    
    <form method="post" action="options.php">
        <?php settings_fields('FlickrPhotogallery'); ?>
        <?php do_settings_sections('FPG_settings_page'); ?>
        <?php submit_button(__('Save options', 'FlickrPhotogallery')); ?>
    </form>
    
</div>