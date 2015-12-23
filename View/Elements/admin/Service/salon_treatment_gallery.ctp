<style>
ul.dropdown-menu{
    min-width: 90px !important;
}

.single-picture .dropdown-menu > li > a{
    line-height: 4px !important;    
}


#accordion2 .gallery > li {
    background: none repeat scroll 0 0 #e9e9e9;
    height: 149px;
    margin: 8px;
    text-align: center;
    width: 201px;
            
}
.treatment > li {
    padding:0;
}
#accordion2 .gallery > li > img {
    height: 100%;
    width: 100%;
}
.vendor-setting .v-setting-right {
    width: 100%;
}
</style>

<div class="panel-group v-setting-right pull-left staff-service-box" id="accordion2" role="tablist" aria-multiselectable="true">
<?php
  if(!empty($services)){
     
      
        foreach($services as $seKey=>$service){
	   
            $froTggl = 'Service_'.$service['SalonService']['id'];
	    
        ?>
                  <div class="panel panel-default">
                    <div class="panel-heading headingOne" role="tab" id="headingOne">
                      <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion2" href="#<?php echo $froTggl; ?>" aria-expanded="true" aria-controls="collapseOne" class="<?php echo ($seKey !=0)?'collapsed' :'';?>">
                          <?php
                           echo  (!empty($service['SalonService']['eng_name'])) ? $service['SalonService']['eng_name'] : $service['Service']['eng_name'];
                          ?> <!--<span>View all<i class="fa fa-angle-down"></i></span>-->
                         
                          <?php if(empty($service['children'])) { ?>
			  	<span title="Edit" alt="Edit"  class="pull-right unbndTgle alert_error"><i class="icon-edit"></i></span>

			  <?php }else { ?>
				<span title="Edit" alt="Edit"  class="pull-right unbndTgle"><i class="icon-edit"></i></span>
			   
			   <?php } ?>
                        </a>
                      </h4>
                    </div>
                    <div id="<?php echo $froTggl; ?>" class="panel-collapse collapse accordion-body <?php echo  ($seKey == 0 )? 'in':''; ?>" role="tabpanel" aria-labelledby="headingOne">
                      <div class="panel-body">
                      <i class="glyphicon-remove_2 pull-right removeEdit" style="display:none"></i>
                      <?php
                    $imagesArr = array();
                    if(isset($service['children']) && !empty($service['children'])){
                        foreach($service['children'] as $child){
                            if(isset($child['SalonServiceImage']) && !empty($child['SalonServiceImage'])){
                                foreach($child['SalonServiceImage'] as $thImg){
                                    $tags = array();
                                    $tag['id']          =   $child['SalonService']['id'];
                                    $tag['name']        =   (!empty($child['SalonService']['eng_name'])) ? $child['SalonService']['eng_name'] : $child['Service']['eng_name'];
                                    $tag['order']    =   $thImg['order'];
                                    if(!array_key_exists($thImg['image'],$imagesArr)){
                                        $tags[] = $tag;
                                    }
                                    else{
                                        $tags = unserialize($imagesArr[$thImg['image']]);
                                        $tags[] = $tag;
                                    }
                                    $imagesArr[$thImg['image']] = serialize($tags);
                                }
                            }
                        }
                    }
              
                    $imageId=array();
                    if(isset($service['SalonServiceImage']) && !empty($service['SalonServiceImage'])){
                        foreach($service['SalonServiceImage'] as $maIng){
                            if(!array_key_exists($maIng['image'],$imagesArr))
                                $imagesArr[$maIng['image']] = '';
                                $imageId[$maIng['image']]= $maIng['id'];
                        }
                    }
                 
                    ?>
                        <ul class="treatment clearfix gallery" id="gallery_<?php echo $service['SalonService']['id']?>">
			
                        	  <?php if(!empty($imagesArr)){
			    $j=0;
			    $rand = time();
                            foreach($imagesArr as $imageVal=>$val){ ?>
                                <li class="single-picture" data-src="/images/Service/original/<?php echo $imageVal; ?>" data-id ="<?php echo @$imageId[$imageVal]; ?>" data-img="<?php echo $imageVal;?>">
                                    <img alt="" data-img="<?php echo $imageVal; ?>" class=" " src="/images/Service/150/<?php echo $imageVal; ?>?timestamp=<?php echo $rand;?>">
                                    <?php if(!empty($val)){
                                        $tags = unserialize($val);
                                        ?>
                                        <div class="tags">
                                            <i class="icon-tag"></i>
                                            <?php
                                           
                                            foreach($tags as $chk=>$tag){
                                                $featured=false;
                                                if($chk > 0){
                                                    echo ",&nbsp;";
                                                }
                                                else{
                                                    echo "&nbsp;";
                                                }
                                                if($tag['order']==0)
                                                    $featured=true;
                                                    if($featured){
                                                echo $this->Html->link('<i class="glyphicon-sheriffs_star"></i>'.ucfirst($tag['name']),'javascript:void(0);',array('escape'=>false,'data-id'=>$tag['id']));
                                                }else{
                                                echo $this->Html->link(ucfirst($tag['name']),'javascript:void(0);',array('escape'=>false,'data-id'=>$tag['id']));    
                                                }
                                            }?>
                                        </div>
                                        <?php
                                        
                                    }?>
                                    <div class="extras">
                                       <!-- <div class="extras-inner">-->
                                        
                                        <div class="dropdown pull-right">
                                            <button class="dropdown-toggle" type="button"data-toggle="dropdown">
                                                <span class="icon-edit"></span>
                                            </button>
                                            <ul class="dropdown-menu" >
						
						
                                                <li data-img="<?php echo $imageVal;?>">
						<a class="fancybox-thumbs<?php echo $service['SalonService']['id']; ?>" href="<?php echo $this->Html->url('/images/Service/original/'.$imageVal); ?>" data-fancybox-group="thumb"><i class="icon-search">View</i></a></li>
						<!--<a href="<?php echo $this->Html->url('/images/Service/original/'.$imageVal); ?>" title="<?php echo $imageVal; ?>" class='lightGal' rel="group-1"><i class="icon-search"></i>View</a></li>-->
                                                <li data-img="<?php echo $imageVal;?>"><a href="javascript:void(0);" role="menuitem" data-id="<?php echo $service['SalonService']['id']; ?>" data-image="<?php echo $imageVal ?>" class="crop-tpic"><i class="icon-edit"> Crop</i></a></li>
                                                <li data-img="<?php echo $imageVal;?>"><a href="javascript:void(0);" role="menuitem" data-id="<?php echo $service['SalonService']['id']; ?>" class="del-tpic"><i class="icon-trash"> Delete</i></a></li>
                                            </ul>
                                          </div>
                                      <!--  </div>
                                     -->   
                                    </div>
                                </li>   
                            <?php }
                            
                        }
                        else{ ?>
                           
                        <?php } ?>
                        </ul>
			
                        <div class="editGallery" style="display:none">
                    
                       <?php if(!empty($imagesArr)){ ?>
                        <a title="" rel="tooltip" class="btn btn-primary mrgn-rgt10 mrgn-btm10" data-id="<?php echo $service['SalonService']['id']?>" id="associateImages" href="javascript:void(0);" data-original-title="Upload new images"><i class="icon-cloud-upload"></i> Associate Images</a>
                        <?php echo $this->Form->button('Make Featured',array('type'=>'submit','class'=>'btn btn-primary  submitUser', 'data-id'=>$service['SalonService']['id'],'id'=>"featuredImage",'label'=>false,'div'=>false));?>
                    <?php } ?>
			</div>
			
		
			<div class=" uploadImages">
			  
				   <?php echo $this->Form->input('image.',array('class'=>'upImage','data-id'=>$service['SalonService']['id'],'type'=>'file','multiple','label'=>false,'div'=>false,'style'=>'display:none;')); ?>
				   <a title="" rel="tooltip" class="btn btn-primary uploadImg" data-id="<?php echo $service['SalonService']['id'] ?>" multiple="multiple" href="javascript:void(0);" data-original-title="Upload new images"><i class="icon-cloud-upload"></i> Upload images</a>
			    
		       </div>
                      </div>
                    </div>
                  </div>
		  
		<!--<script type="text/javascript">
			    $(document).ready(function() {
				$('#gallery_<?php echo $service['SalonService']['id']?>').lightGallery().destroy();
				$(document).find('#gallery_<?php echo $service['SalonService']['id']?>').find('.extras ul.dropdown-menu li').on('click',function(){
				    $('#gallery_<?php echo $service['SalonService']['id']?>').lightGallery().destroy();	
				    if($(this).find('a').hasClass('lightGal')){
					$('#gallery_<?php echo $service['SalonService']['id']?>').lightGallery({
					    showThumbByDefault:true,
					    addClass:'showThumbByDefault',
					    controls:true,
					    onCloseAfter  : function(el) {
					    $('#gallery_<?php echo $service['SalonService']['id']?>').lightGallery().destroy();
					    },
					});
				    }
				});
			    });
		</script> -->
		<script type="text/javascript">
		$(document).ready(function() {
                  
		    
		    $('.fancybox-thumbs<?php echo $service['SalonService']['id']?>').fancybox({
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
<?php


}
    }?>  
                  
</div>
         

