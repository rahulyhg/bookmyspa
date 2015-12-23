<div class="row-fluid">
    <div class="span12" id="ajaxload">
    <div class="box">
    <?php
       if(count($publicAlbums)>0){
    ?>
        <ul class="tabs tabs-inline tabs-top">
            <?php
               //$uid = $this->Session->read('Auth.User.id');
                   $i=0;
                   foreach($publicAlbums as $publicAlbum){
                      $uid = $publicAlbum['Album']['user_id'];
                      $albumid = base64_encode($publicAlbum['Album']['id']);
                      if($i==0){
                                   $class="active";
                                }
                                else{
                                   $class='';
                                }
                   ?>
                       <li class="<?php echo $class;?>">
                               <a href="#album<?php echo $publicAlbum['Album']['id'];?>" data-toggle='tab'><i class="icon-inbox"></i> <?php echo $publicAlbum['Album']['eng_name'];?></a>
                       </li>
                       <?php 
                   $i++;}
              ?>
        </ul>
      
        <div class="tab-content padding tab-content-inline tab-content-bottom">
            <?php
                $j=0;
                foreach($publicAlbums as $publicAlbum){
                      $uid = $publicAlbum['Album']['user_id'];
                      $albumid = base64_encode($publicAlbum['Album']['id']);
                      if($j==0){
                                   $class="active";
                                }
                                else{
                                   $class='';
                                }
                   ?>
                   
                   <div class="tab-pane <?php echo $class;?>" id="album<?php echo $publicAlbum['Album']['id'];?>">
                           <ul class="gallery">
                           <?php
                            if(count($publicAlbum['AlbumFile'])){
                                $images =array();  $youtube = array();
                                foreach($publicAlbum['AlbumFile'] as $image){
                                         if($image['image']){
                                                 $images[] = $image;   
                                          }else{
                                                 $youtube[] = $image;  
                                         }
                                 }
                             ?>
                              <div class="">
                                    <h4>
                                            Images
                                    </h4>
                             </div>
                             </br>
                            <?php
                            
                            foreach($publicAlbum['AlbumFile'] as $images){
                                  ?>
                                 <li class="<?php echo $class;?>">
                                    <a href="#">
                                        <?php
                                            echo $this->Html->image('/images/'.$uid.'/AlbumFile/150/'.$images['image']);
                                        ?>
                                    </a>
                                        <div class="extras">
                                                <div class="extras-inner">
                                                <a href="<?php echo $this->Html->url('/images/'.$uid.'/AlbumFile/800/'.$images['image']); ?>" title="<?php echo $images['eng_title']; ?>" class='colorbox-image' rel="group-1"><i class="icon-search"></i></a>
                                                        <a href="javascript:void(0)" onclick="return confirm('Are you sure?');" data-id="<?php echo  base64_encode($images['id']); ?>" class='del-gallery-pic delete'><i class="icon-trash"></i></a>
                                                </div>
                                        </div>
                                </li>
                            <?php
                            }
                            $j++;
                            }
                            ?>
                          </ul>
                          
                          
                          <ul class="gallery">
                          <div class="">
                                    <h4>
                                            Videos
                                    </h4>
                             </div>
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
									<a href="<?php echo $this->Html->url($url); ?>" class='youtube' rel="group-1"><i class="icon-search"></i></a>
									<a href="javascript:void(0)" onclick="return confirm('Are you sure?');" data-id="<?php echo  base64_encode($video['id']); ?>" class='del-gallery-pic delete'><i class="icon-trash"></i></a>
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
            <?php }?>
        </div>
    <?php
        }else{
                echo "No Albums Found";
        }
    ?>
    </div>
  <!--      <ul class="gallery">
       
        
        </ul>
  -->  </div>
</div>
<script>
$(document).ready(function(){
    
      /*********************colorbox to view  images/videos **********************************/     
    $(".colorbox-image").colorbox({rel:'group-1', slideshow:true});
    $(".youtube").colorbox({iframe:true, innerWidth:640, innerHeight:390});
    
     /*********************Ajax code to delete image/video **********************************/  
    $(document).on('click','.del-gallery-pic.delete', function(){
      $this =  $(this);  
     itsId = $(this).data('id');
     deleteUrl = "<?php echo $this->Html->url(array('controller'=>'Albums','action'=>'deleteImage','admin'=>true)); ?>";
     deleteUrl = deleteUrl+'/'+itsId;
     $.ajax({
        url:deleteUrl,
        success:function(result){
        $this.closest("li").remove();
        },
     });
     
    });   
});
</script>
