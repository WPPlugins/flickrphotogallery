<?php
/*
 * Plugin Name: FlickrPhotogallery
 * Plugin URI: http://thetibashole.tumblr.com
 * Description: A plugin to show latest photos from Flickr
 * Version: 1.1
 * Author: Tiziano Basile
 * Author URI: http://thetibashole.tumblr.com
 */
class FlickrPhotogallery
{
    public $FPG_shortcodeId = 0;
    
    public function __construct()
    {
        load_plugin_textdomain('FlickrPhotogallery', false, dirname( plugin_basename( __FILE__ )) . '/languages');
        if(is_admin()){
            add_action('admin_init', array($this,'FPG_install'));
            add_action('admin_menu', array($this,'FPG_add_menu_page'));
            add_action('init', array($this,'FPG_addTinyMCEButtons'));
        }else{
            add_action('wp_enqueue_scripts', array($this,'FPG_enqueue_scripts'));
            add_shortcode('FlickrPhotogallery', array($this,'FPG_shortcode'));
        }
    }
    /***************************************************************************
     *PLUGIN INSTALLATION AND OPTIONS INITIALIZATION                           *
     ***************************************************************************
     * This function initialize the default options after the plugin activation
     * and set the settings, sections and fields for the admin page
     */
    public function FPG_install(){
        include_once dirname(__FILE__).'/include/install.php';
    }
    /***************************************************************************
     *MENU PAGE INITIALIZATION                                                 *
     ***************************************************************************
     * This function create an admin page to set the default options
     * for the plugin
     */
    public function FPG_add_menu_page(){
        add_menu_page(
                __('FlickrPhotogallery','FlickrPhotogallery'),
                __('FlickrPhotogallery','FlickrPhotogallery'),
                'administrator',
                'FPG_settings_page',
                array($this,'FPG_settings_page_cb')
                //$icon_url
        );
    }
    /***************************************************************************
     *MENU PAGE CALLBACK                                                       *
     ***************************************************************************
     * This function retrive the admin page markup from the included file
     */
    public function FPG_settings_page_cb(){
        include_once dirname(__FILE__).'/include/admin_page.php';
    }
    /***************************************************************************
     *SCRIPT INCLUSION                                                         *
     ***************************************************************************
     * This function includes the necessary scripts for frontend operation
     */
    public function FPG_enqueue_scripts()
    {
        wp_enqueue_script('jquery');
        wp_enqueue_style('FPG_style', plugins_url('/flickrphotogallery/css/FPG_style.css'));
        wp_enqueue_style('FPG_fancyboxStyle', plugins_url('/flickrphotogallery/script/fancybox/jquery.fancybox-1.3.4.css'));
        wp_enqueue_script('FPG_function', plugins_url('/flickrphotogallery/script/FPG_function.js'));
        wp_enqueue_script('FPG_fancybox', plugins_url('/FlickrPhotogallery/script/fancybox/jquery.fancybox-1.3.4.pack.js'));
        wp_enqueue_script('FPG_facybox_easing', plugins_url('/FlickrPhotogallery/script/fancybox/jquery.easing-1.3.pack.js')); 
    }
    /***************************************************************************
     *SHORTCODE HANDLER                                                        *
     ***************************************************************************
     * This function let the plugin to add the shortcode support in the
     * post editing page
     */
    public function FPG_shortcode($atts, $content = null){
        include_once dirname(__FILE__).'/include/phpFlickr.php';
        $f = new phpFlickr('353077acfc6e1a37787fedb753efeaba');
        //increment a variable to identify each shortcode used
        //in order to assign it a different class-identifier
        $this->FPG_shortcodeId ++;
        $options = get_option('FlickrPhotogallery');
        $atts = shortcode_atts(
                            array(
                                'stream' => $options['stream'],
                                'flickr_id' => $options['flickr_id'],
                                'photoset_id' => $options['photoset_id'],
                                'number_of_images' => $options['number_of_images'],
                                'caption' => $options['caption'],
                                'show_as' => $options['show_as'],
                                'width' => $options['width'],
                                'border_color' => $options['border_color'],
                                'use_fancybox' => $options['use_fancybox']
                            ),
                            $atts
                );
        $image_width = self::FPG_set_image_dimension($atts);
        $show_as_class = self::FPG_list_or_slideshow($atts);
        $images = self::FPG_get_image_list($atts, $f);
        include_once dirname(__FILE__).'/include/gallery_style.php';
        include_once dirname(__FILE__).'/include/gallery_markup.php';
    }
    /***************************************************************************
     *TINYMCE PLUGIN                                                           *
     ***************************************************************************
     * The next three functions allows the plugin to add two new buttons
     * to TinyMCE: the first to add the shortcode and the second
     * to add the shortcode with parameters
     */
    public function FPG_addTinyMCEButtons()
    {
        if(!current_user_can('edit_posts') && !current_user_can('edit_pages')) {return;}
        if (get_user_option('rich_editing') == 'true')
        {
            add_filter('mce_external_plugins', array($this,'FPG_addPlugin'));
            add_filter('mce_buttons', array($this,'FPG_registerButtons'));
        }
    }
    public function FPG_registerButtons($buttons)
    {
        array_push($buttons, "|", "FlickrPhotogallery", "FlickrPhotogalleryWithParameters");
        return $buttons;
    }
    public function FPG_addPlugin($plugin_array)
    {
        $plugin_array['FlickrPhotogallery'] = plugins_url('/flickrphotogallery/script/FPG_mcebutton.js');
        return $plugin_array;
    }
    /***************************************************************************
     *PRIVATE FUNCTIONS                                                        * 
     ***************************************************************************
     * Next functions are used in the shortcode handler and in order:
     * 1) Set the dimension the image must be retrieved
     * 2) Set a different class name beetween list-view and slidesho-view
     * 3) Retrieve the images in a array
     */
    private function FPG_set_image_dimension($atts){
        switch ($atts['width'])
        {
            case ($atts['width']<=75):
                $_imageDim = 'square';
                break;
            case (($atts['width'] > 75) && ($atts['width'] <= 100)):
                $_imageDim = 'thumbnail';
                break;
            case (($atts['width'] > 100) && ($atts['width'] <= 240)):
                $_imageDim = 'small';
                break;
            case (($atts['width'] > 240) && ($atts['width'] <= 500)):
                $_imageDim = 'medium';
                break;
            case (($atts['width'] > 500) && ($atts['width'] <= 640)):
                $_imageDim = 'medium_640';
                break;
            case ($atts['width'] > 640):
                $_imageDim = 'large';
                break;
            default:
                $_imageDim = 'small';                
        }
        return $_imageDim;
    }
    
    
    private function FPG_list_or_slideshow($atts){
        if($atts['show_as'] == 'list'){
            $_class_switcher = 'List';
        }
        else{$_class_switcher = 'Slide';}
        return $_class_switcher;
    }
    
    private function FPG_get_image_list($atts, $f){
        switch($atts['stream'])
        {
             case ('public'):
                 $_images = $f->photos_getRecent(NULL, NULL, $atts['number_of_images'], 1);
                 break;
             case ('user'):
                 $_images = $f->people_getPublicPhotos($atts['flickr_id'], NULL, NULL, $atts['number_of_images']);
                 break;
             case('photoset'):
                 $_images = $f->photosets_getPhotos($atts['photoset_id'], NULL, NULL, $atts['number_of_images']);
                 break;
             case ('group'):
                 $_images = $f->groups_pools_getPhotos($atts['flickr_id'], NULL, NULL, NULL, NULL, $atts['number_of_images']);
                 break;                 
        }
        if(array_key_exists('photoset',$_images))
        {
            $_images['photos'] = $_images['photoset'];
            unset($_images['photoset']);
        }
        return $_images;
    }
}
$FPG = new FlickrPhotogallery;
include_once dirname(__FILE__).'/fpg_widget.php';
?>
