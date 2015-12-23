<?php echo $this->Html->css('jquery.bxslider'); ?>
                <?php echo $this->Html->script('jquery.bxslider'); ?>
           <?php $lang =  Configure::read('Config.language'); ?>     
<?php $galleryImages = $this->requestAction(array('controller' => 'search', 'action' => 'getvenueimages',$user['User']['id']));//pr($galleryImages);?>

<?php


if(!empty($galleryImages)) { ?>
        <h2 class="share-head">
            Gallery
            <a rel="<?php echo $user['User']['id'] ; ?>" href="javascript:void(0);" class="cross  close-this"><img  src="/img/cross.png" alt="" title=""></a>
            <ul class="share-icon-set">
                <li>Share</li>
                <li><a href="#" class="msz"></a></li>
                <li><a href="#" class="fb"></a></li>
                <li><a href="#" class="tweet"></a></li>
                <li><a href="#" class="google"></a></li>
            </ul>
        </h2>
        <div class="deal-box-outer">
            <div class="gallery demo demo_<?php echo $user['User']['id'];?>">
                    <ul class="bxslider" id="bxslider_<?php echo $user['User']['id'];?>">
                       <?php
                       $j = 0;
                       foreach($galleryImages as $image) {
                            if($j<6){
                                        echo "<li data-thumb='/images/".$user['User']['id']."/VenueImage/800/".$image['VenueImage']['image']."'>".$this->Html->image('/images/'.$user['User']['id'].'/VenueImage/800/'.$image['VenueImage']['image']) ."</li>";
                            }
                            $j++;
                        } ?>
                    </ul>
                    
                    <div id="bx-pager">
				<?php
				$i = 0;
				foreach($galleryImages as $image) {
                                    if($i<6){
                                    ?>
				<a data-slide-index="<?php echo $i;?>" href="javascript:void(0);"><?php echo $this->Html->image('/images/'.$user['User']['id'].'/VenueImage/150/'.$image['VenueImage']['image']); ?></a>
				<?php } $i++; } ?>
			</div>
            </div>
            
        </div>
<?php }else{
    echo 'No Image found ...';
    } ?>
    
 <script>
 
     $(document).ready(function() {
        $(document).find('#bxslider_'+<?php echo $user['User']['id'];?>).bxSlider({
		    auto: true,
		    pagerCustom: '#bx-pager',
               
	});
     });
    
 </script>   