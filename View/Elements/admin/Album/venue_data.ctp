<div class="box" >
    <div class="box-title">
        <h3><i class="icon-picture"></i> Venue Images</h3>

		<?php echo $this->Html->link(__('Upload Image'), 'javascript:void(0)', array('data-type' => 'image', 'data-id' => '', 'class' => 'btn btn-primary pull-right addeditImage')); ?>
    </div>
    <div class="box-content">
        
        <ul class="gallery no-mrgn" id="lightGallery">
            <?php
            $uid = $this->Session->read('Auth.User.id');
            if (count($venueImages) > 0) {

                foreach ($venueImages as $venueImage) {
                    ?>
                    <li data-src="<?php echo $this->webroot . 'images/' . $uid . '/VenueImage/original/' . $venueImage['VenueImage']['image']; ?>" >
                        <a href="#">
                            <?php
                            echo $this->Html->image('/images/' . $uid . '/VenueImage/150/' . $venueImage['VenueImage']['image']);
                            ?>
                        </a>
                        <div class="extras">
                            <div class="extras-inner">
				<a class="fancybox-thumbs1" href="<?php echo $this->Html->url('/images/' . $uid . '/VenueImage/original/' . $venueImage['VenueImage']['image']); ?>" data-fancybox-group="thumb"><i class="icon-search"></i></a>
                                <!--<a href="<?php echo $this->Html->url('/images/' . $uid . '/VenueImage/original/' . $venueImage['VenueImage']['image']); ?>" title="" class='lightGal' rel="group-1"><i class="icon-search"></i></a>-->
                                <a href="javascript:void(0)" onclick="return deletefunc('<?php echo base64_encode($venueImage['VenueImage']['id']); ?>');" data-id="<?php echo base64_encode($venueImage['VenueImage']['id']); ?>" class=''><i class="icon-trash"></i></a>
                            </div>
                        </div>
                    </li>
                <?php
                }
            } else {
                echo "No Images Found";
            }
            ?>  </ul>
  
    </div>
</div>

<div class="box" >
    <div class="box-title">
        <h3><i class="icon-picture"></i> Venue Video</h3>
		<?php echo $this->Html->link(__('Upload Video'), 'javascript:void(0)', array('data-type' => 'image', 'data-id' => '', 'class' => 'btn btn-primary pull-right mrgn-tp12 addeditVideo')); ?>
    </div>
    <div class="box-content">
        
        <ul class="gallery no-mrgn" id="lightGallery">
        <?php
        $uid = $this->Session->read('Auth.User.id');
				if(count($venueVideos)){
					foreach($venueVideos as $video){ 
					if($this->common->getYoutubeThumb($video['VenueVideo']['video'])){ ?>
					<li>
					<a href="#"><?php echo $this->Html->Image($this->common->getYoutubeThumb($video['VenueVideo']['video'])); ?></a>
						<div class="extras">
							<div class="extras-inner">
							  <?php  $url = preg_replace("/\s*[a-zA-Z\/\/:\.]*youtube.com\/watch\?v=([a-zA-Z0-9\-_]+)([a-zA-Z0-9\/\*\-\_\?\&\;\%\=\.]*)/i","http://www.youtube.com/embed/$1?rel=0&amp;wmode=transparent",$video['VenueVideo']['video']); ?>
							  <a class="fancyboxvid1 fancybox.iframe" href="<?php echo $url; ?>" data-fancybox-group="thumb"><i class="icon-search"></i><?php echo $this->Html->Image($this->common->getYoutubeThumb($video['VenueVideo']['video']), array('style' => 'display:none;')); ?></a>
									<!--<a href="<?php echo $this->Html->url($url); ?>" class='youtube' rel="group-1"><i class="icon-search"></i></a>-->
									<?php //echo $this->Html->link('<i class="icon-pencil"></i>','javascript:void(0)',array('data-type'=>'video','data-album_id'=>base64_encode($publicAlbum['Album']['id']),'data-id'=>base64_encode($video['id']),'class'=>'addeditImage','escape'=>false)); ?>
									<a href="javascript:void(0)"  data-id="<?php echo  base64_encode($video['VenueVideo']['id']); ?>" class='del-gallery-video delete'><i class="icon-trash"></i></a>
							</div>
						</div>
				   </li>
					<?php }
					}
				}else{
					echo "No video found!!";
				   } ?>
           
        </ul>
        
    </div>
</div>
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
                
                        },
			helpers : {
					thumbs : {
						width  : 100,
						height : 70
					}
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
<!--<script type="text/javascript">
    $(document).ready(function() {
        $('#lightGallery').lightGallery({
            showThumbByDefault: true,
            addClass: 'showThumbByDefault',
            controls: true
        });
    });
</script>-->