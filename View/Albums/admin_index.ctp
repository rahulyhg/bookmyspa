<?php echo $this->Html->script('bootbox'); 
echo $this->Html->script('fancy/jquery.fancybox.js?v=2.1.5');
echo $this->Html->css('fancy/jquery.fancybox.css?v=2.1.5');
echo $this->Html->script('fancy/jquery.fancybox-thumbs.js?v=1.0.7');
echo $this->Html->css('fancy/jquery.fancybox-thumbs.css?v=1.0.7');?>
<script>
$(document).ready(function(){
    var addeditURL = "<?php echo $this->Html->url(array('controller'=>'Albums','action'=>'album_element','admin'=>true)); ?>";
    $('#ajax_box').load(addeditURL,function(){
        $(document).find(".gallery-dynamic").imagesLoaded(function(){
                $(document).find(".gallery-dynamic").masonry({
                    itemSelector: 'li',
                    columnWidth: 201,
                    isAnimated: true
                });
            });
    });
    var $modal = $('#commonSmallModal');
    var $modal2 = $('#commonContainerModal');
    var itsId  = "";
    
    $(document).on('click','.addedit' ,function(){
        var itsId = $(this).attr('data-id');
        var addeditURL = "<?php echo $this->Html->url(array('controller'=>'Albums','action'=>'add_album','admin'=>true)); ?>";
        addeditURL = addeditURL+'/'+itsId
        // function in modal_common.js
        $('body').modalmanager('loading');
        fetchModal($modal,addeditURL);
    });
    $(document).on('click','.remove_album' ,function(){
        bootbox.alert('Maximum number of albums allowed in allery are 5.');
    });
    $(document).on('click','.video_alert' ,function(){
        bootbox.alert('Each album contain 10 videos only. Please create another album to add more videos.');
    });
    
    
    $(document).on('click','.delete_album' ,function(){
        if(confirm('Are you sure you want to delete this album?')){
            return true;
        }else{
            return false;
        }
    });
    
     $(document).on('click','.showAlbum' ,function(){
        var itsId = $(this).attr('data-id');
        var addeditURL = "<?php echo $this->Html->url(array('controller'=>'Albums','action'=>'album_data','admin'=>true)); ?>";
        addeditURL = addeditURL+'/'+itsId
        // function in modal_common.js
        $('body').modalmanager('loading');
        fetchModal($modal2,addeditURL);
    });
    /*********************Ajax code to add add new album**********************************/
    
    $modal.on('click', '.create', function(e){
        var theClick = $(this);
        buttonLoading(theClick);
        var options = { 
            success:function(res){
                buttonSave(theClick);
                theClick.addClass('request_sent');
                // onResponse function in modal_common.js
                if(onResponse($modal,'Album',res)){
                    var data = jQuery.parseJSON(res);
                        if(data.id){
                            var addeditURL = "<?php echo $this->Html->url(array('controller'=>'Albums','action'=>'album_element','admin'=>true)); ?>";
                            addeditURL = addeditURL+'/'+data.id
                             $('#ajax_box').load(addeditURL,function(){
                                $(document).find(".gallery-dynamic").imagesLoaded(function(){
                                        $(document).find(".gallery-dynamic").masonry({
                                            itemSelector: 'li',
                                            columnWidth: 201,
                                            isAnimated: true
                                        });
                                });
                            });
                           // window.location.href =addeditURL; 
                             return false;
                        }
                     }else{
                        return false;   
                        }
               }
        }
       if (!theClick.hasClass('request_sent')) {
            $('#AlbumAdminAddAlbumForm').submit(function(){
                $(this).ajaxSubmit(options);
                $(this).unbind('submit');
                $(this).bind('submit');
                return false;
                
            });
       }else{
            e.preventDefault();
       }
       
    }); 
});
</script>
<div class="row-fluid">
    <div class="span12" id="ajax_box">
        <?php echo $this->element("admin/Album/album_data");?>
  </div>
</div>


    <script>
$(document).ready(function(){
    
     var $modal = $('#commonSmallModal');
        var $modal2 = $('#commonContainerModal');
        var itsId  = "";   
        $(document).on('click','.addeditImage' ,function(){
        var albumId = $(this).data('album_id');
        var itsId = $(this).data('id');
        var type  = $(this).attr('data-type');
        var addeditURL = "<?php echo $this->Html->url(array('controller'=>'Albums','action'=>'add_image','admin'=>true)); ?>";
        addeditURL = addeditURL+'/'+albumId+'/'+type+'/'+itsId;
        // function in modal_common.js
        $('body').modalmanager('loading');
        fetchModal($modal,addeditURL);
    });   
        
    /*********************colorbox to view  images/videos **********************************/     
    //$(".colorbox-image").colorbox({rel:'group-1', slideshow:true});
    //$(".youtube").colorbox({iframe:true, innerWidth:640, innerHeight:390});
    
    $('body').on('click', '.youtube', function() {
        $('.youtube').colorbox({rel: $(this).attr('rel'),iframe:true, innerWidth:640, innerHeight:390});
    });
    
    /*********************Ajax code to add add/edit  new image/video **********************************/  
   
        $modal.on('click', '.save', function(e){
            var url = $('#AlbumFileUrl').val();
            if (validYT(url) !== false) {
                var optionsImage = { 
                    success:function(res){
                        // onResponse function in modal_common.js
                        if(onResponse($modal,'AlbumFile',res)){
                            var data = jQuery.parseJSON(res);
                                if(data.id){
                                    var addeditURL = "<?php echo $this->Html->url(array('controller'=>'Albums','action'=>'album_element','admin'=>true)); ?>";
                                    addeditURL = addeditURL+'/'+data.id;
                                     //$('body').modalmanager('loading');
                                     $('#ajax_box').load(addeditURL,function(){
                                        $(document).find(".gallery-dynamic").imagesLoaded(function(){
                                                $(document).find(".gallery-dynamic").masonry({
                                                    itemSelector: 'li',
                                                    columnWidth: 201,
                                                    isAnimated: true
                                                });
                                        });
                                        $(".youtube").colorbox({iframe:true, innerWidth:640, innerHeight:390});
                                    });
                                     return false;
                                }
                             }else{
                                return false;   
                                }
                       }
                }
                $('#AlbumFileAdminAddImageForm').submit(function(){
                   $(this).ajaxSubmit(optionsImage);
                    $(this).unbind('submit');
                    $(this).bind('submit');
                    return false;
                    
                   
                });
            }else{
                bootbox.alert('Please enter a valid youtube url.');
                return false;
            }
    });
    
      /*********************colorbox to view  images/videos **********************************/     
    //$(".colorbox-image").colorbox({rel:'group-1', slideshow:true});
    //$(".youtube").colorbox({iframe:true, innerWidth:640, innerHeight:390});
    //
    
     /*********************Ajax code to delete image/video **********************************/  
    $(document).on('click','.del-gallery-pic.delete', function(e){
        if(confirm('Are you sure you want to delete this video?')){
                e.preventDefault();     // stop the default action if u need 
                e.stopPropagation();
                $this =  $(this);  
                itsId = $(this).data('id');
                deleteUrl = "<?php echo $this->Html->url(array('controller'=>'Albums','action'=>'deleteImage','admin'=>true)); ?>";
                deleteUrl = deleteUrl+'/'+itsId;
                var album_id = $(this).attr('rel');
                var albumId = $(this).attr('test-id');
                $.ajax({
                 url:deleteUrl,
                 success:function(result){
                    $this.closest("li").remove();
                    $(".youtube").colorbox({iframe:true, innerWidth:640, innerHeight:390});
                        var addeditURL = "<?php echo $this->Html->url(array('controller'=>'Albums','action'=>'album_element','admin'=>true)); ?>";
                        addeditURL = addeditURL+'/'+album_id;
                       // $this.closest("li").remove();
                       $('#ajax_box').load(addeditURL);
                        $('#lightGallery'+albumId).lightGallery({
                            showThumbByDefault:true,
                            addClass:'showThumbByDefault',
                            controls:true
                        });
                 },
            });
        }
     
    });
    
    /*****************************************************************************/
    $(document).on('click','.alert_add_image' , function(){
      bootbox.alert('Each album contain 20 images only. Please create another album.'); 
     });
    
    
});

function deletefunc($this,album){
    $("#lightGallery"+album).lightGallery().destroy();
    if(confirm('Are you sure you want to delete this image?')){
        itsId = $this;
       deleteUrl = "<?php echo $this->Html->url(array('controller'=>'Albums','action'=>'deleteImage','admin'=>true)); ?>";
        deleteUrl = deleteUrl+'/'+itsId+'/'+album;
       $.ajax({
        url:deleteUrl,
        success:function(result){
        if(result != ''){
            album_id = $.trim(result);
        }
        var addeditURL = "<?php echo $this->Html->url(array('controller'=>'Albums','action'=>'album_element','admin'=>true)); ?>";
        addeditURL = addeditURL+'/'+album_id;
        // $this.closest("li").remove();
        $('#ajax_box').load(addeditURL);
        $('#lightGallery'+album).lightGallery({
			showThumbByDefault:true,
			addClass:'showThumbByDefault',
			controls:true
		    });
        
        },
    });
    }
}



function validYT(url) {
  var p = /^(?:https?:\/\/)?(?:www\.)?youtube\.com\/watch\?(?=.*v=((\w|-){11}))(?:\S+)?$/;
  return (url.match(p)) ? RegExp.$1 : false;
}


</script>
 
