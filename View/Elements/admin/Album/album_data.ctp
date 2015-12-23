   <?php //echo $this->Html->css('lightslider/lightGallery'); ?>
   <?php //echo $this->Html->script('lightslider/lightGallery'); ?>
   
  <div class="box">
        <div class="box-title">
                            <h3>
                                   <i class="icon-picture"></i>
                                   Public Album
				</h3>
			      <?php if($total >= 5) { ?>
				    <?php echo $this->Html->link('<button class="btn"><i class="icon-plus"></i> Create Album</button>','javascript:void(0);',array('data-id'=>'','escape'=>false,'class'=>'remove_album pull-right ')) ; ?>
 
			     <?php }else{ ?>
				    <?php echo $this->Html->link('<button class="btn"><i class="icon-plus"></i> Create Album</button>','javascript:void(0);',array('data-id'=>'','escape'=>false,'class'=>'addedit pull-right')) ; ?>

			     <?php }?>
                    </div></br>
                    <div class="box-content nopadding vendor-deal-sec business-list">
    
    <?php
       if(count($albums)>0){
    ?>
        <ul class="tabs tabs-inline tabs-top nav nav-tabs">
            <?php
                   //$uid = $this->Session->read('Auth.User.id');
                   $i=0;
                   foreach($albums as $publicAlbum){
                      $uid = $publicAlbum['Album']['user_id'];
                      $albumid = base64_encode($publicAlbum['Album']['id']);
                       if(isset($sel_id) && ($sel_id == $publicAlbum['Album']['id'])){
			     $class="active";
			}else if($i==0 && empty($sel_id)){
			     $class="active";

			}else{
			      $class='';
                        }
                   ?>
                   
                       <li role="presentation" class="<?php echo $class;?>">
                               <a href="#album<?php echo $publicAlbum['Album']['id'];?>" role="tab" data-toggle='tab'><?php echo $publicAlbum['Album']['eng_name'];?></a>
                       </li>
                     
                       <?php 
                   $i++;}
              ?>
	   <!--   <li role="presentation" class="<?php //echo $class;?> pull-right col-sm-2" onclick="">
                              <a> <i class="icon-pencil pull-right"></i>  </a> 
                </li>-->
        </ul>
      
        <div class="tab-content padding tab-content-inline tab-content-bottom ">
            <?php
                $j=0;
		//pr($albums);
                foreach($albums as $publicAlbum){
                      $uid = $publicAlbum['Album']['user_id'];
                      $albumid = base64_encode($publicAlbum['Album']['id']);
                      if(isset($sel_id) && ($sel_id == $publicAlbum['Album']['id'])){
			     $class="active";
			}else if($j==0  && empty($sel_id)){
                        $class="active";
			}else{
                              $class='';
                        }
			$j++;
			$total_images = $this->Common->countAlbumFiles($publicAlbum['Album']['id'],'image');
                        $total_videos = $this->Common->countAlbumFiles($publicAlbum['Album']['id'],'video');
                           
                   ?>
             <div role="tabpanel" class="tab-pane <?php echo $class;?>" id="album<?php echo $publicAlbum['Album']['id'];?>">
                            <div class="highlight-toolbar nopadding">
			      <h4>Images
                                   
				    <?php
				    $add_image_class =   ($total_images <20)? "addeditImage":"alert_add_image";
				    echo $this->Html->link(__('Upload Image') ,'javascript:void(0)',array('data-type'=>'image','data-album_id'=>base64_encode($publicAlbum['Album']['id']),'class'=>'btn btn-primary  pull-right mrgn-tp0 '.$add_image_class)); ?>
				    <?php echo ($total_images <20) ?  $this->Html->link(__('Edit Album') ,'javascript:void(0)',array('data-id'=>base64_encode($publicAlbum['Album']['id']),'class'=>'pull-right btn mrgn-rgt10 mrgn-tp0 addedit')) : $this->Html->link(__('Edit Album') ,'javascript:void(0)',array('data-id'=>base64_encode($publicAlbum['Album']['id']),'class'=>'pull-right btn  mrgn-tp0 addedit'));  ?>
				    <?php echo $this->Html->link(__('Delete Album') ,'/admin/albums/deleteAlbum/'.base64_encode($publicAlbum['Album']['id']),array('class'=>'delete_album pull-right btn mrgn-rgt10 mrgn-tp0')) ?>
			      </h4>
                            </div>
                                    
                             </br>
			     <div class="demo">
			   <ul id="lightGallery<?php echo $publicAlbum['Album']['id'];?>" class="gallery">
                           <?php
			     $imagess =array();  $youtube = array();
                            if(count($publicAlbum['AlbumFile'])){
                              
                                foreach($publicAlbum['AlbumFile'] as $image){
                                         if($image['image']){
                                                 $imagess[] = $image;   
                                          }else{
                                                 $youtube[] = $image;  
                                         }
                                 }
                             ?>
                            <?php
                            foreach( $imagess as $images){
				  ?>
                                    <li data-src="<?php echo $this->webroot.'images/'.$uid.'/AlbumFile/original/'.$images['image']; ?>" >
					<a href="#">
					    <?php
						echo $this->Html->image('/images/'.$uid.'/AlbumFile/150/'.$images['image']);
					    ?>
					</a>
					<div class="extras">
						<div class="extras-inner">
						      <a class="fancybox-thumbs<?php echo $publicAlbum['Album']['id'];?>" href="<?php echo $this->Html->url('/images/'.$uid.'/AlbumFile/original/'.$images['image']); ?>" data-fancybox-group="thumb"><i class="icon-search"></i></a>
						<!--<a href="<?php echo $this->Html->url('/images/'.$uid.'/AlbumFile/original/'.$images['image']); ?>" title="<?php echo $images['eng_title']; ?>" class='lightGal' rel="group-1"><i class="icon-search"></i></a>-->
						<a href="javascript:void(0)" onclick="return deletefunc('<?php echo  base64_encode($images['id']); ?>','<?php echo $publicAlbum['Album']['id'];?>');" data-id="<?php echo  base64_encode($images['id']); ?>" class=''><i class="icon-trash"></i></a>
						</div>
					</div>
				    </li>
                            <?php
                            }
                           
                            }else{
			      echo "No Image found!!";
			    }
                            ?>
                          </ul>
                          </div>
			  <hr>
			   <div class="highlight-toolbar nopadding">
			  <div class="pull-left">
                                    <h4>
                                            Videos
                                    </h4>
                             </div>
                                    <div class="pull-right">
                                            <div class="">
                                                    <div class="">
                                                     <?php
						     $video_alert =  ($total_videos <10)?'addeditImage':'video_alert'; 
						     echo $this->Html->link(__('Upload Video') ,'javascript:void(0)',array('data-type'=>'video','data-album_id'=>base64_encode($publicAlbum['Album']['id']),'class'=>'btn btn-primary  pull-right no-mrgn '.$video_alert)); ?> 
                                                     </div>
                                            </div>
                                    </div>
                            </div>
                          <ul class="gallery">
                             </br>
                            <?php
				if(count($youtube)){
					foreach($youtube as $video){ 
					if($this->common->getYoutubeThumb($video['url'])){ ?>
					<li>
					<a href="#"><?php echo $this->Html->Image($this->common->getYoutubeThumb($video['url'])); ?></a>
						<div class="extras">
							<div class="extras-inner">
							  <?php  $url = preg_replace("/\s*[a-zA-Z\/\/:\.]*youtube.com\/watch\?v=([a-zA-Z0-9\-_]+)([a-zA-Z0-9\/\*\-\_\?\&\;\%\=\.]*)/i","http://www.youtube.com/embed/$1?rel=0&amp;wmode=transparent",$video['url']); ?>
							  
							   <a class="fancyboxvid<?php echo $publicAlbum['Album']['id'];?> fancybox.iframe" href="<?php echo $url; ?>" data-fancybox-group="thumb"><i class="icon-search"></i><?php echo $this->Html->Image($this->common->getYoutubeThumb($video['url']), array('style' => 'display:none;')); ?></a>
							  
									<!--<a href="<?php echo $this->Html->url($url); ?>" class='youtube' rel="group-1"><i class="icon-search"></i></a>-->
									<?php //echo $this->Html->link('<i class="icon-pencil"></i>','javascript:void(0)',array('data-type'=>'video','data-album_id'=>base64_encode($publicAlbum['Album']['id']),'data-id'=>base64_encode($video['id']),'class'=>'addeditImage','escape'=>false)); ?>
									<a href="javascript:void(0)"  data-id="<?php echo  base64_encode($video['id']); ?>" test-id = "<?php echo $publicAlbum['Album']['id'];  ?>" rel="<?php echo base64_encode($publicAlbum['Album']['id']) ?>" class='del-gallery-pic delete'><i class="icon-trash"></i></a>
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
		   
		   
		   
		<script type="text/javascript">
		 
		 $(document).ready(function() {
                    $(".fancyboxvid<?php echo $publicAlbum['Album']['id'];?>")
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
            
                    
		    $('.fancybox-thumbs<?php echo $publicAlbum['Album']['id'];?>').fancybox({
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
		   
            <?php }?>
        </div>
    <?php
        }else{
                echo "No Albums Found";
        }
    ?>
    </div>
<style>
      .remove_album{
	    margin: 12px 0 0;
      }
</style>

 <script type="text/javascript">
		
	</script>
    