<?php
/*
 * Plugin options are stored in this file
 */

/*------------------------------------------------------------------------------
 *  OPTIONS VERIFY AND INIT
 *----------------------------------------------------------------------------*/
if(false == get_option('FlickrPhotogallery')){
    add_option(
        'FlickrPhotogallery',
        array(
            'stream' => 'public',
            'flickr_id' => '',
            'photoset_id' => '',
            'number_of_images' => 3,
            'caption' => __('See my last shoots','FlickrPhotogallery'),
            'show_as' => 'list',
            'use_fancybox' => 1,
            'width' => 400,
            'border_color' => '#ccc'
        )
    );
}
/*------------------------------------------------------------------------------
 *  SECTIONS INIT
 *----------------------------------------------------------------------------*/
add_settings_section(
        'FPG_settings_section',
        __('FlickrPhotogallery Settings','FlickrPhotogallery'),
        'FPG_settings_section_cb',
        'FPG_settings_page'
);
/*------------------------------------------------------------------------------
 *  SECTIONS CALLBACK
 *----------------------------------------------------------------------------*/
function FPG_settings_section_cb(){
    wp_enqueue_style( 'farbtastic' );
    wp_enqueue_script( 'farbtastic' );
    wp_enqueue_script('FPG_colorpicker', plugins_url('flickrphotogallery/script/colorpicker.js'));
    wp_enqueue_script('FPG_id_finder', plugins_url('flickrphotogallery/script/idFinder.js'));
    wp_enqueue_script('FPG_show_field_listener', plugins_url('flickrphotogallery/script/showFieldsListener.js'));
    echo '<p>'.__('Set the default options for the plugin','FlickrPhotogallery').'</p>';
}
/*------------------------------------------------------------------------------
 *  FIELDS INIT
 *----------------------------------------------------------------------------*/
/********
 *STREAM*
 ********/
add_settings_field(
    'stream',
    '<h4><label for="stream">'.__('Stream','FlickrPhotogallery').'</label></h4>',
    'FPG_stream_field_cb',
    'FPG_settings_page',
    'FPG_settings_section',
    array(
        __('Select the default stream from where to retrieve images','FlickrPhotogallery')
    )
);
/***********
 *FLICKR ID*
 ***********/
add_settings_field(
    'flickr_id',
    '<h4><label for="flickr_id">'.__('Flickr Id','FlickrPhotogallery').'</label></h4>',
    'FPG_flickr_id_field_cb',
    'FPG_settings_page',
    'FPG_settings_section',
    array(
        __('Insert the default Flickr id to use','FlickrPhotogallery')
    )
);
/*************
 *PHOTOSET ID*
 *************/
add_settings_field(
    'photoset_id',
    '<h4><label for="photoset_id">'.__('Photoset Id','FlickrPhotogallery').'</label></h4>',
    'FPG_photoset_id_field_cb',
    'FPG_settings_page',
    'FPG_settings_section',
    array(
        __('Insert the id of the photoset you want to show by default','FlickrPhotogallery')
    )
);
/******************
 *NUMBER OF IMAGES*
 ******************/
add_settings_field(
    'number_of_images',
    '<h4><label for="number_of_images">'.__('Number of Images to show','FlickrPhotogallery').'</label></h4>',
    'FPG_number_of_images_field_cb',
    'FPG_settings_page',
    'FPG_settings_section',
    array(
        __('Insert the numer of images you want to show by default','FlickrPhotogallery')
    )
);
/*********
 *CAPTION*
 *********/
add_settings_field(
    'caption',
    '<h4><label for="caption">'.__('Caption','FlickrPhotogallery').'</label></h4>',
    'FPG_caption_field_cb',
    'FPG_settings_page',
    'FPG_settings_section',
    array(
        __('Insert the caption you want to show by default before images','FlickrPhotogallery')
    )
);
/*********
 *SHOW AS*
 *********/
add_settings_field(
    'show_as',
    '<h4><label for="show_as">'.__('Show images as','FlickrPhotogallery').'</label></h4>',
    'FPG_show_as_field_cb',
    'FPG_settings_page',
    'FPG_settings_section',
    array(
        __('Insert the way you want to show images by default','FlickrPhotogallery')
    )
);
/**************
 *USE FANCYBOX*
 **************/
add_settings_field(
    'use_fancybox',
    '<h4><label for="use_fancybox">'.__('Use Fancybox','FlickrPhotogallery').'</label></h4>',
    'FPG_use_fancybox_field_cb',
    'FPG_settings_page',
    'FPG_settings_section',
    array(
        __('Select to use Fancybox effects on image click or to redirect the visitor to the related Flickr url','FlickrPhotogallery')
    )
);
/*******
 *WIDTH*
 *******/
add_settings_field(
    'width',
    '<h4><label for="width">'.__('Image Width','FlickrPhotogallery').'</label></h4>',
    'FPG_width_field_cb',
    'FPG_settings_page',
    'FPG_settings_section',
    array(
        __('Select the default slideshow width in pixels (don\'t use "px")','FlickrPhotogallery')
    )
);
/**************
 *BORDER COLOR*
 **************/
add_settings_field(
    'border_color',
    '<h4><label for="border_color">'.__('Border Color','FlickrPhotogallery').'</label></h4>',
    'FPG_border_color_field_cb',
    'FPG_settings_page',
    'FPG_settings_section',
    array(
        __('Select the default border color for images (it will be the slideshow border color if you selected the slideshow view)','FlickrPhotogallery')
    )
);
/*------------------------------------------------------------------------------
 *  FIELDS CALLBACK
 *----------------------------------------------------------------------------*/
/********
 *STREAM*
 ********/
function FPG_stream_field_cb($args){
    $options = get_option('FlickrPhotogallery');
    $html  = '<ul>';
    $html .=    '<li>';
    $html .=        '<select id="stream" name="FlickrPhotogallery[stream]">';
    $html .=            '<option value="public"'.selected('public', $options['stream'], FALSE).'>'.__('Public','FlickrPhotogallery').'</option>';
    $html .=            '<option value="user"'.selected('user', $options['stream'], FALSE).'>'.__('User','FlickrPhotogallery').'</option>';
    $html .=            '<option value="photoset"'.selected('photoset', $options['stream'], FALSE).'>'.__('Photoset','FlickrPhotogallery').'</option>';
    $html .=            '<option value="group"'.selected('group', $options['stream'], FALSE).'>'.__('Group','FlickrPhotogallery').'</option>';
    $html .=        '</select>';
    $html .=        '<span class="description">'.$args[0].'</span>';
    $html .=    '</li>';
    $html .= '</ul>';
    echo $html;
}
/*********
 *USER ID*
 *********/
function FPG_flickr_id_field_cb($args){
    $options = get_option('FlickrPhotogallery');
    
    $html  = '<ul>';
    $html .=    '<li>';
    $html .=        '<input type="text" id="flickr_id" name="FlickrPhotogallery[flickr_id]" value="'.$options['flickr_id'].'" />';
    $html .=        '<span class="description">'.$args[0].' </span>';
    $html .=        '<a class="FPG_find_id" href="#" title"'.__('Find your ID','FlickrPhotogallery').'">'.__('Find your ID','FlickrPhotogallery').'</a>';
    $html .=    '</li>';
    $html .= '</ul>';
    echo $html;
}
/*************
 *PHOTOSET ID*
 *************/
function FPG_photoset_id_field_cb($args){
    $options = get_option('FlickrPhotogallery');
    
    $html  = '<ul>';
    $html .=    '<li>';
    $html .=        '<input type="text" id="photoset_id" name="FlickrPhotogallery[photoset_id]" value="'.$options['photoset_id'].'" />';
    $html .=        '<span class="description">'.$args[0].'</span>';
    $html .=    '</li>';
    $html .= '</ul>';
    echo $html;
}
/******************
 *NUMBER OF IMAGES*
 ******************/
function FPG_number_of_images_field_cb($args){
    $options = get_option('FlickrPhotogallery');
    
    $html  = '<ul>';
    $html .=    '<li>';
    $html .=        '<input type="text" id="number_of_images" name="FlickrPhotogallery[number_of_images]" value="'.$options['number_of_images'].'" />';
    $html .=        '<span class="description">'.$args[0].'</span>';    
    $html .=    '</li>';
    $html .= '</ul>';
    echo $html;
}
/*********
 *CAPTION*
 *********/
function FPG_caption_field_cb($args){
    $options = get_option('FlickrPhotogallery');
    
    $html  = '<ul>';
    $html .=    '<li>';
    $html .=        '<input type="text" id="caption" name="FlickrPhotogallery[caption]" value="'.$options['caption'].'" />';
    $html .=        '<span class="description">'.$args[0].'</span>';    
    $html .=    '</li>';
    $html .= '</ul>';
    echo $html;
}
/*********
 *SHOW AS*
 *********/
function FPG_show_as_field_cb($args){
    $options = get_option('FlickrPhotogallery');
    
    $html  = '<ul>';
    $html .=    '<li>';
    $html .=        '<select id="show_as" name="FlickrPhotogallery[show_as]">';
    $html .=            '<option value="list"'.selected('list', $options['show_as'], FALSE).'>'.__('List','FlickrPhotogallery').'</option>';
    $html .=            '<option value="slideshow"'.selected('slideshow', $options['show_as'], FALSE).'>'.__('Slideshow','FlickrPhotogallery').'</option>';
    $html .=        '</select>';
    $html .=        '<span class="description">'.$args[0].'</span>';
    $html .=    '</li>';
    $html .= '</ul>';
    echo $html;
}
/**************
 *USE FANCYBOX*
 **************/
function FPG_use_fancybox_field_cb($args){
    $options = get_option('FlickrPhotogallery');
    
    $html  = '<ul>';
    $html .=    '<li>';
    $html .=        '<input type="hidden" id="use_fancybox" name="FlickrPhotogallery[use_fancybox]" value="0" />';
    $html .=        '<input type="checkbox" id="use_fancybox" name="FlickrPhotogallery[use_fancybox]" value="1" '.  checked('1', $options['use_fancybox'], FALSE) . '/>';
    $html .=        '<span class="description">'.$args[0].'</span>';
    $html .=    '</li>';
    $html .= '</ul>';
    echo $html;
}
/*******
 *WIDTH*
 *******/
function FPG_width_field_cb($args){
    $options = get_option('FlickrPhotogallery');
    
    $html  = '<ul>';
    $html .=    '<li>';
    $html .=        '<input type="text" id="width" name="FlickrPhotogallery[width]" value="'.$options['width'].'" />';
    $html .=        '<span class="description">'.$args[0].'</span>';    
    $html .=    '</li>';
    $html .= '</ul>';
    echo $html;
}
/**************
 *BORDER COLOR*
 **************/
function FPG_border_color_field_cb($args){
    $options = get_option('FlickrPhotogallery');
    
    $html  = '<ul>';
    $html .=    '<li>';
    $html .=        '<input type="text" id="border_color" name="FlickrPhotogallery[border_color]" value="'.$options['border_color'].'" />';
    $html .=        '<div id="colorpicker"></div>';
    $html .=        '<span class="description">'.$args[0].'</span>';    
    $html .=    '</li>';
    $html .= '</ul>';
    echo $html;
}
/*------------------------------------------------------------------------------
 *  SETTINGS REGISTRATION
 *----------------------------------------------------------------------------*/
register_setting('FlickrPhotogallery', 'FlickrPhotogallery');
?>
