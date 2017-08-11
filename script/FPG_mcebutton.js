(function() {
    tinymce.create('tinymce.plugins.FlickrPhotogallery', {
        init : function(ed, url) {
            ed.addButton('FlickrPhotogallery', {
                title : 'FlickrPhotogallery',
                image : url+'/flickr.png',
                onclick : function() {
                     ed.selection.setContent('[FlickrPhotogallery]');
                     ed.undoManager.add();
                }
            });
            ed.addButton('FlickrPhotogalleryWithParameters', {
                title : 'FlickrPhotogallery With Parameters',
                image : url+'/flickr.png',
                onclick : function() {
                     ed.selection.setContent('[FlickrPhotogallery stream="" user_id="" photoset_id="" number_of_images="" caption="" show_as="" width="" border_color="" use_fancybox="true"]');
                     ed.undoManager.add();
                }
            });
        },
        createControl : function(n, cm) {
            return null;
        }
    });
    tinymce.PluginManager.add('FlickrPhotogallery', tinymce.plugins.FlickrPhotogallery);
})();