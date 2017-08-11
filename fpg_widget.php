<?php
/*
 * Initialize the widget
 */
add_action('widgets_init', 'FPG_registerWidget');

/*
 * Callback function for add_action
 */
function FPG_registerWidget(){
    register_widget('FPG_widget');
}
/*
 * Extends the WP_widget class to create the widget for this plugin
 */
class FPG_widget extends WP_widget{
    /*
     * This is the "constructor" function, it enqueues jquery and a custom function js
     * for the widget, and the style for it, include also the phpFlickr class.
     * 
     * Sets the basic options for the widget to be shown in the admin panel and sets
     * the widget controls settings, then initialize the widget
     */
    public function FPG_widget(){
        //widget setting
        if(is_admin()){
            add_action('admin_print_styles',array($this,'widgetEnqueueAdminStuff'));
        }else{
            add_action('init',array($this,'widgetEnqueueStuff'));
        }
        include_once dirname(__FILE__).'/include/phpFlickr.php';
        $widget_ops = array('classname'=>'fpg_widget', 
            'description' => __('This widget shows the last <em>n</em> photos from a Flickr account','FlickrPhotogallery'));
        //widget-control settings
        $control_ops = array('width'=> 500, 'height'=> 350, 'id_base'=>'fpg_widget');
        $this->WP_Widget('fpg_widget', __('FlickrPhotogallery Widget','FlickrPhotogallery'), $widget_ops, $control_ops);
    }
    /*
     * enqueue scripts in frontend
     */
    public function widgetEnqueueStuff()
    {
        wp_enqueue_script('jquery');
        wp_enqueue_script('FPG_widgetFunction', WP_PLUGIN_URL.'/FlickrPhotogallery/script/widgetFunction.js');
        wp_enqueue_style('FPG_WidgetStyle', WP_PLUGIN_URL .'/FlickrPhotogallery/css/widgetStyle.css');

    }
    public function widgetEnqueueAdminStuff()
    {
                    //enqueue color picker
        wp_enqueue_style( 'farbtastic' );
        wp_enqueue_script( 'farbtastic' );    
    }
    /*
     * Prints the form in the widget admin page
     * 
     * The javacript below the form is for adding some effects, such as field hiding
     * @param $instace 
     */
    public function form($instance){
        $type = "public";
        $userId = "";
        $photosetId = "";
        $numOfImages = 5;
        $title = "";
        $showAs = "list";
        $width = "240";
        $borderColor = '#cccccc';
        $useFancybox = false;
        $defaults = array('title'=>$title,
                          'stream'=>$type,
                          'flickr_id'=>$userId,
                          'photoset_id'=>$photosetId,
                          'number_of_images'=>$numOfImages,
                          'show_as' => $showAs,
                          'width' => $width,
                          'border_color' => $borderColor,
                          'use_fancybox' => $useFancybox);
        $instance = wp_parse_args((array)$instance, $defaults);
    include_once dirname(__FILE__).'/include/widget/widget_admin.php';
    include_once dirname(__FILE__).'/include/widget/widget_script.php';
    }
    /*
     * Update the options for the widget
     * 
     * @param array @new_instance The options to set after updating
     * @param array @old_instance The options to be updated 
     * 
     * @return array
     */
    public function update($new_instance, $old_instance){
        $instance = $old_instance;
        
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['stream'] = $new_instance['stream'];
        $instance['flickr_id'] = $new_instance['flickr_id'];
        $instance['photoset_id'] = $new_instance['photoset_id'];
        $instance['number_of_images'] = $new_instance['number_of_images'];
        $instance['show_as'] = $new_instance['show_as'];
        $instance['width'] = $new_instance['width'];
        $instance['border_color'] = $new_instance['border_color'];
        $instance['use_fancybox'] = $new_instance['use_fancybox'];
        return $instance;
    }
    /*
     * Prints the widget
     * For first extract the argouments and set some variables, then check which
     * type of pool is selected by the user and set an array containing the images.
     * Prints the $before_widget element
     * Prints the widget, changing the classes due to the user selection (slideshow or list)
     * Prints the $after_widget element
     */
    public function widget($args, $instance){
        extract($args);
        $title = apply_filters('widget_title',$instance['title']);
        //create a new instance of phpFlickr class
        //!!!DO NOT MODIFY/DELETE THE ARGUMENT!!!
        $FPG_widget = new phpFlickr('353077acfc6e1a37787fedb753efeaba');
        $title = $instance['title'];
        $type = $instance['stream'];
        $userId = $instance['flickr_id'];
        $photosetId = $instance['photoset_id'];
        $numOfImages = $instance['number_of_images'];
        $showAs = $instance['show_as'];
        $borderColor = $instance['border_color'];
        $width = $instance['width'];
        switch ($width)
        {
            case ($width<=75):
                $imageDim = 'square';
                break;
            case (($width > 75) && ($width <= 100)):
                $imageDim = 'thumbnail';
                break;
            case (($width > 100) && ($width <= 240)):
                $imageDim = 'small';
                break;
            case (($width > 240) && ($width <= 500)):
                $imageDim = 'medium';
                break;
            case (($width > 500) && ($width <= 640)):
                $imageDim = 'medium_640';
                break;
            case ($width > 640):
                $imageDim = 'large';
                break;
            default:
                $imageDim = 'small';                
        } 
        //$useFancybox = $instance['useFancybox'];
        if($instance['use_fancybox'])
        {
            $useFancybox = $instance['use_fancybox'];
        }else{$useFancybox = false;}
         switch($type)
         {
             case ('public'):
                 //set the array that contains the images
                 $images = $FPG_widget->photos_getRecent(NULL, NULL, $numOfImages, 1);
                 break;
             case ('user'):
                 $images = $FPG_widget->people_getPublicPhotos($userId, NULL, NULL, $numOfImages);
                 break;
             case('photoset'):
                 $images = $FPG_widget->photosets_getPhotos($photosetId, NULL, NULL, $numOfImages);
                 break;
             case ('group'):
                 $images = $FPG_widget->groups_pools_getPhotos($userId, NULL, NULL, NULL, NULL, $numOfImages);
                 break;
         }
            if(array_key_exists('photoset',$images))
            {
                $images['photos'] = $images['photoset'];
                unset($images['photoset']);
            } 
        echo $before_widget;
        include_once dirname(__FILE__).'/include/widget/widget_markup.php';
        echo $after_widget;
    }
}
?>
