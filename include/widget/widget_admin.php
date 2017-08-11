<?php
/*******************************************************************************
 * This file contains the markup used to render the widget admin form          *
 ******************************************************************************/
?>
<table class="form-table">
    <tbody>
        <tr valign="top">
            <th scope="row">
                <label for="<?php echo $this->get_field_id('title');?>"><?php __('Title:','FlickrPhotogallery'); ?></label>              
            </th>
            <td>
                <input id="<?php echo $this->get_field_id('title');?>" name="<?php echo $this->get_field_name('title');?>" value="<?php echo $instance['title'];?>" style="width:100%" /> 
            </td>
        </tr>
        <tr valign="top">
            <th scope="row">
                <label for="<?php echo $this->get_field_id('stream');?>"><?php __('Stream:','FlickrPhotogallery'); ?></label>                
            </th>
            <td>
                <select id="<?php echo $this->get_field_id('stream');?>" name="<?php echo $this->get_field_name('stream');?>">
                    <option value="public" <?php selected($instance['stream'], "public"); ?>><?php __('Public','FlickrPhotogallery'); ?></option>
                    <option value="user" <?php selected($instance['stream'], "user"); ?>><?php __('User','FlickrPhotogallery'); ?></option>
                    <option value="photoset" <?php selected($instance['stream'], "photoset"); ?>><?php __('Photoset','FlickrPhotogallery'); ?></option>
                    <option value="group" <?php selected($instance['stream'], "group");?>><?php __('Group','FlickrPhotogallery'); ?></option>
                </select>
                <span class="description"><?php __('You can show public images or from a specific user, photoset or group','FlickrPhotogallery'); ?></span>               
            </td>
        </tr>
        <tr valign="top" id="<?php echo $this->id;?>idRow">
            <th scope="row">
                <label for="<?php echo $this->get_field_id('flickr_id');?>" id="<?php echo $this->id;?>idLabel"><?php __('Your Flickr User Id:','FlickrPhotogallery'); ?></label>   
            </th>
            <td>
                <input type="text" name="<?php echo $this->get_field_name('flickr_id');?>" id="<?php echo $this->get_field_id('flickr_id');?>" value="<?php echo $instance['flickr_id']; ?>" />
                <span class="description"><a href="#" id="<?php echo $this->id;?>findMyIdWidget"><?php __('Find your ID','FlickrPhotogallery'); ?></a></span>
            </td>
        </tr>
        <tr valign="top" id="<?php echo $this->id;?>photosetRow">
            <th scope="row">
                <label for="<?php echo $this->get_field_id('photoset_id');?>"><?php __('Your Photoset Id:','FlickrPhotogallery'); ?></label>
            </th>
            <td>
                <input type="text" name="<?php echo $this->get_field_name('photoset_id');?>" id="<?php echo $this->get_field_id('photoset_id');?>" value="<?php echo $instance['photoset_id']; ?>" />    
                <span class="description"><?php __('Insert the Id of your Photoset here','FlickrPhotogallery'); ?></span>    
            </td>
        </tr>
        <tr valign="top">
            <th scope="row">
                <label for="<?php echo $this->get_field_id('number_of_images');?>"><?php __('Number of Images to Show:','FlickrPhotogallery'); ?></label>    
            </th>
            <td>
                <input type="text" name="<?php echo $this->get_field_name('number_of_images');?>" id="<?php echo $this->get_field_id('number_of_images');?>" value="<?php echo $instance['number_of_images']; ?>" />
                <span class="description"><?php __('Insert the number of images you want to show','FlickrPhotogallery'); ?></span>               
            </td>
        </tr>
        <tr valign="top">
            <th scope="row">
                <label for="<?php echo $this->get_field_id('show_as');?>"><?php __('Show images as:','FlickrPhotogallery'); ?></label>
            </th>
            <td>
                <select id="<?php echo $this->get_field_id('show_as');?>" name="<?php echo $this->get_field_name('show_as');?>">
                    <option value="list" <?php selected($instance['show_as'], 'list');?>><?php __('List','FlickrPhotogallery'); ?></option>
                    <option value="slideshow" <?php selected($instance['show_as'], 'slideshow');?>><?php __('Slideshow','FlickrPhotogallery'); ?></option>
                </select>
            </td>
        </tr>
        <tr valign="top" id="<?php echo $this->id; ?>widthRow">
            <th scope="row">
                <label for="<?php echo $this->get_field_id('width'); ?>"><?php __('Slideshow Width:','FlickrPhotogallery'); ?></label>
            </th>
            <td>
                <input type="text" name="<?php echo $this->get_field_name('width');?>" id="<?php echo $this->get_field_id('width');?>" value="<?php echo $instance['width'];?>" />
            </td>
        </tr>
<tr valign="top">
  <th scope="row">
    <label for="<?php echo $this->get_field_id('border_color');?>"><?php __('Border color','FlickrPhotogallery'); ?></label>
  </th>
  <td>
    <input type="text" id="<?php echo $this->get_field_id('border_color');?>" name="<?php echo $this->get_field_name('border_color');?>" value="<?php echo $instance['border_color']; ?>" />
    <div id="<?php echo $this->id;?>-FPG_colorpicker"></div>
  </td>
</tr>        
        <tr valign="top">
           <th scope="row">
               <label for="<?php echo $this->get_field_id('use_fancybox');?>"><?php __('Use fancybox','FlickrPhotogallery'); ?></label> 
           </th>
           <td>
               <input type="checkbox" name="<?php echo $this->get_field_name('use_fancybox');?>" id="<?php echo $this->get_field_id('use_fancybox');?>" value="true" <?php checked($instance['use_fancybox'], "true");?>/>
           </td>
       </tr>
    </tbody>
</table>