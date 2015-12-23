<script type="text/javascript">
		$(document).ready(function() {
                    $(".fancyboxvid1")
                    .attr('rel', 'gallery')
                    .fancybox({
                        openEffect  : 'elastic',
                        closeEffect : 'elastic',
                        nextEffect  : 'elastic',
                        prevEffect  : 'elastic',
                        padding     : 10,
                        margin      : 50,
                        beforeShow  : function() {
                            // Find the iframe ID
                            var id = $.fancybox.inner.find('iframe').attr('id');
                
                        }
                    });
            
                    $(".fancyboxvid2")
                    .attr('rel', 'gallery')
                    .fancybox({
                        openEffect  : 'elastic',
                        closeEffect : 'elastic',
                        nextEffect  : 'elastic',
                        prevEffect  : 'elastic',
                        padding     : 10,
                        margin      : 50,
                        beforeShow  : function() {
                            // Find the iframe ID
                            var id = $.fancybox.inner.find('iframe').attr('id');
                
                        }
                    });
		    
		    $('.fancybox-thumbs1').fancybox({
			        openEffect  : 'elastic',
				closeEffect : 'elastic',
				prevEffect : 'elastic',
				nextEffect : 'elastic',
				closeBtn  : 'elastic',
				nextClick : true,
				helpers : {
					thumbs : {
						width  : 100,
						height : 70
					}
				}
			});
		    
		    $('.fancybox-thumbs2').fancybox({
			        openEffect  : 'elastic',
				closeEffect : 'elastic',
				prevEffect : 'elastic',
				nextEffect : 'elastic',
				closeBtn  : 'elastic',
				nextClick : true,
				helpers : {
					thumbs : {
						width  : 100,
						height : 70
					}
				}
			});
            
            });
	</script>
<style>
    .view{
        cursor: pointer;
    }
</style>
<div class="wrapper">
      <?php
      $noImage = true;
      if (count($files)) {  $noImage = false; ?>
        <div class="container gallery-sec photoGal">
        <h2 class="main-heading col-sm-12">
            <span class="cap-heading">- <?php echo __('Photos',true)?> -</span>
            <span class="view">
                <?php   if (count($files)>5) {  ?> 
                <a href="javascript:void(0)" class="viewPhoto"><span class="view-all-wrap"><?php echo __('View_all_photos'); ?></span><i class="glyphicon glyphicon-chevron-right"></i></a>
                <?php } ?>
            </span>
        </h2>
       <?php
            $i = 0;
            $t = count($files); ?>
            <div class="photoGal-gallery">
            <?php 
            foreach ($files as $image) {
	    //echo Configure::read('BASE_URL').'<br>';
		//if(file_exists(Configure::read('BASE_URL').'/images/'.$image['Album']['user_id'].'/AlbumFile/original/'.$image['AlbumFile']['image']))
		//{
		?>
                    <div class="featured1 <?php echo ($i >= 5)?'show_all':''; ?>" <?php echo ($i >= 5)?'style="display:none"':''; ?> data-src="<?php echo $this->webroot.'images/'.$image['Album']['user_id'].'/AlbumFile/original/'.$image['AlbumFile']['image']; ?>"  >
                        <div class="picture-space">
			     <a class="fancybox-thumbs1" href="<?php echo $this->webroot.'images/'.$image['Album']['user_id'].'/AlbumFile/original/'.$image['AlbumFile']['image']; ?>" data-fancybox-group="thumb"><?php echo $this->Html->image('/images/'.$image['Album']['user_id'] . '/AlbumFile/150/' . $image['AlbumFile']['image']); ?></a>
                        </div>
                        
                    </div>
                <?php
		$i++;
		//}
		
            }
            ?>
            </div>
        <div class="clearfix"></div> 
        <?php   if (count($files)>5) {  ?> 
        <div class="view-all">
	    <a href="javascript:void(0)" class="view-all viewPhoto"><span class="view-all-wrap"><?php echo __('View_all_photos'); ?></span> <i class="glyphicon glyphicon-chevron-right"></i></a>
        </div>
        <?php } ?>
    </div>
    <?php } ?>
<?php   if (count($videos)) { $noImage = false;  ?>
    <div class="massage-outer">
        <div class="container gallery-sec videoGal">
            <h2 class="main-heading col-sm-12">
                <span class="cap-heading">- <?php echo __('Videos',true)?> -</span>
                <span class="view">
                    <?php   if (count($videos)>5) {  ?> 
                    <a href="javascript:void(0)" class="viewVideo"><span class="view-all-wrap"><?php echo __('View_all_videos'); ?></span><i class="glyphicon glyphicon-chevron-right"></i></a>
                    <?php } ?>
                </span>
            </h2>
        
            <?php
            $i = 0;
            $t = count($videos); ?>
            <div class="videoGal-gallery">
            <?php 
            foreach ($videos as $video) {
                if ($this->common->getYoutubeThumb($video['AlbumFile']['url'])) {
                    $url = preg_replace("/\s*[a-zA-Z\/\/:\.]*youtube.com\/watch\?v=([a-zA-Z0-9\-_]+)([a-zA-Z0-9\/\*\-\_\?\&\;\%\=\.]*)/i", "http://www.youtube.com/embed/$1?rel=0&amp;wmode=transparent", $video['AlbumFile']['url']);
                    ?>
                    <div class="featured1 <?php echo ($i >= 5)?'show_all':''; ?>" <?php echo ($i >= 5)?'style="display:none"':''; ?> data-src="<?php echo $video['AlbumFile']['url']; ?>" >
                        <div class="picture-space">
                           <a class="fancyboxvid1 fancybox.iframe" href="<?php echo $url; ?>">
                            <?php echo $this->Html->Image($this->common->getYoutubeThumb($video['AlbumFile']['url'])); ?></a>
                        </div>
                    </div>
                                
                <?php $i++;
                }
            } ?>
            </div>
            <div class="clearfix"></div>
            <?php   if (count($videos)>5) {  ?>
            <div class="view-all">
                            <a href="javascript:void(0);" class="view-all viewVideo"><span class="view-all-wrap"><?php echo __('View_all_videos'); ?></span> <i class="glyphicon glyphicon-chevron-right"></i></a>
            </div>
            <?php } ?>
        </div>
    </div>
 <?php   } ?>
<?php   if (count($venuImages)) {  $noImage = false; ?> 
<div class="container gallery-sec venuePhoto">
    <h2 class="main-heading col-sm-12">
        <span class="cap-heading">- <?php echo __('Venue_photo',true)?> -</span>
        <span class="view">
            <?php   if (count($venuImages)>5) {  ?> 
            <a href="javascript:void(0)" class="venuePic"><span class="view-all-wrap"><?php echo __('View_all_venuePhotos'); ?></span><i class="glyphicon glyphicon-chevron-right"></i></a>
            <?php } ?>
        </span>
    </h2>
    
    <div class="venuePhoto-gallery">
<?php
$i = 0;
foreach ($venuImages as $venueIamge) {
   //echo $imageUrl = Configure::read('BASE_URL').'/images/'.$venueIamge['VenueImage']['user_id'].'/VenueImage/original/'.$venueIamge['VenueImage']['image'].' - ';
//    if(file_exists($imageUrl))
//		{
    ?>
            <div class="featured1 <?php echo ($i >= 5)?'show_all':''; ?>" <?php echo ($i >= 5)?'style="display:none"':''; ?> data-src="<?php echo $this->webroot.'images/'.$venueIamge['VenueImage']['user_id'].'/VenueImage/original/'.$venueIamge['VenueImage']['image']; ?>" >
                <div class="picture-space">
		    <a class="fancybox-thumbs2" href="<?php echo $this->webroot.'images/'.$venueIamge['VenueImage']['user_id'].'/VenueImage/original/'.$venueIamge['VenueImage']['image']; ?>" data-fancybox-group="thumb"><?php echo $this->Html->image('/images/'.$venueIamge['VenueImage']['user_id'] . '/VenueImage/150/' . $venueIamge['VenueImage']['image']); ?></a>
                </div>
            </div>
    <?php $i++;
		//}
		} ?>
    </div>
        <div class="clearfix"></div>
        <?php   if (count($venuImages)>5) {  ?> 
        <div class="view-all">
            <a href="javascript:void(0);" class="view-all venuePic"><span class="view-all-wrap"><?php echo __('View_all_venuePhotos'); ?></span> <i class="glyphicon glyphicon-chevron-right"></i></a>
        </div>
        <?php } ?>
    </div>

<?php } ?>
<?php if($noImage){ ?>
<div class="container gallery-sec ">
        <h2 class="main-heading col-sm-12">
            <span class="cap-heading">- <?php echo __('No_images_in_gallery',true)?> -</span>
        </h2>
</div>
<?php }?>
<?php   if (count($venuVideos)) { $noImage = false;  ?>
    <div class="massage-outer">
        <div class="container gallery-sec videoGal">
            <h2 class="main-heading col-sm-12">
                <span class="cap-heading">- <?php echo __('Venue Videos',true)?> -</span>
                <span class="view">
                    <?php   if (count($venuVideos)>5) {  ?> 
                    <a href="javascript:void(0)" class="viewVenueVideo"><span class="view-all-wrap"><?php echo __('View_all_videos'); ?></span><i class="glyphicon glyphicon-chevron-right"></i></a>
                    <?php } ?>
                </span>
            </h2>
        
            <?php
            $i = 0;
            $t = count($venuVideos); ?>
            <div class="videoGal-gallery">
            <?php 
            foreach ($venuVideos as $video) {
                if ($this->common->getYoutubeThumb($video['VenueVideo']['video'])) {
                    $url1 = preg_replace("/\s*[a-zA-Z\/\/:\.]*youtube.com\/watch\?v=([a-zA-Z0-9\-_]+)([a-zA-Z0-9\/\*\-\_\?\&\;\%\=\.]*)/i", "http://www.youtube.com/embed/$1?rel=0&amp;wmode=transparent", $video['VenueVideo']['video']);
                    ?>
                    <div class="featured1 <?php echo ($i >= 5)?'show_all':''; ?>" <?php echo ($i >= 5)?'style="display:none"':''; ?> data-src="<?php echo $video['VenueVideo']['video']; ?>" >
                        <div class="picture-space">
			    
			    <a class="fancyboxvid2 fancybox.iframe" href="<?php echo $url1; ?>">
                            <?php echo $this->Html->Image($this->common->getYoutubeThumb($video['VenueVideo']['video'])); ?></a>
			    
                        </div>
                    </div>
                <?php $i++;
                }
            } ?>
            </div>
            <div class="clearfix"></div>
            <?php   if (count($videos)>5) {  ?>
            <div class="view-all">
                            <a href="javascript:void(0);" class="view-all viewVenueVideo"><span class="view-all-wrap"><?php echo __('View_all_videos'); ?></span> <i class="glyphicon glyphicon-chevron-right"></i></a>
            </div>
            <?php } ?>
        </div>
    </div>
 <?php   } ?>

</div>
    <script>
        $('.viewPhoto').on('click', function(){
            if($(this).hasClass('up')){
                 $(this).closest('.photoGal').find('.show_all').slideUp(500);
                 $(document).find('.viewPhoto').removeClass('up').html('<span class="view-all-wrap"><?php echo __('View_all_photos'); ?></span> <i class="glyphicon glyphicon-chevron-right"></i>');
            }else{
               $(document).find('.viewPhoto').addClass('up').html('<span class="view-all-wrap"><?php echo __('Hide'); ?></span> <i class="glyphicon glyphicon-chevron-right"></i>');
               $(this).closest('.photoGal').find('.show_all').slideDown(500);    
            }
        });
        
        $('.viewVideo').on('click', function(){
            if($(this).hasClass('up')){
                 $(this).closest('.videoGal').find('.show_all').slideUp(500);
                 $(document).find('.viewVideo').removeClass('up').html('<span class="view-all-wrap"><?php echo __('View_all_videos'); ?></span> <i class="glyphicon glyphicon-chevron-right"></i>');
            }else{
               $(document).find('.viewVideo').addClass('up').html('<span class="view-all-wrap"><?php echo __('Hide'); ?></span> <i class="glyphicon glyphicon-chevron-right"></i>');
               $(this).closest('.videoGal').find('.show_all').slideDown(500);    
            }
        });
        $('.venuePic').on('click', function(){
            if($(this).hasClass('up')){
                 $(this).closest('.venuePhoto').find('.show_all').slideUp(500);
                 $(document).find('.venuePic').removeClass('up').html('<span class="view-all-wrap"><?php echo __('View_all_venuePhotos'); ?></span> <i class="glyphicon glyphicon-chevron-right"></i>');
            }else{
               $(document).find('.venuePic').addClass('up').html('<span class="view-all-wrap"><?php echo __('Hide'); ?></span> <i class="glyphicon glyphicon-chevron-right"></i>');
               $(this).closest('.venuePhoto').find('.show_all').slideDown(500);    
            }
        });
         $('.viewVenueVideo').on('click', function(){
            if($(this).hasClass('up')){
                 $(this).closest('.videoGal').find('.show_all').slideUp(500);
                 $(document).find('.viewVenueVideo').removeClass('up').html('<span class="view-all-wrap"><?php echo __('View_all_videos'); ?></span> <i class="glyphicon glyphicon-chevron-right"></i>');
            }else{
               $(document).find('.viewVenueVideo').addClass('up').html('<span class="view-all-wrap"><?php echo __('Hide'); ?></span> <i class="glyphicon glyphicon-chevron-right"></i>');
               $(this).closest('.videoGal').find('.show_all').slideDown(500);    
            }
        });
        
        
//        $('.photoGal-gallery, .venuePhoto-gallery, .videoGal-gallery').lightGallery({
//                showThumbByDefault:true,
//                addClass:'showThumbByDefault',
//                controls:true,
//                videoAutoplay:false,
//		onSlideAfter:function(plugin){
//                    if($(document).find('div.lightGallery-slide').length > 0){
//                        $(document).find('div.lightGallery-slide').each(function(){
//                            var theJSli = $(this);
//                            if(! theJSli.hasClass('current')){
//                                if(theJSli.find('iframe').length > 0){
//                                    var url = theJSli.find('iframe').attr('src');
//                                    theJSli.find('iframe').attr('src', '');
//                                    theJSli.find('iframe').attr('src', url);
//                                }
//                            }
//                        });
//                    }
//                }
//        });
	 /*********************colorbox to view  images **********************************/     
	
        </script>