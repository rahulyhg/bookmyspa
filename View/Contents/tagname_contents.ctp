<script>
   function getMoreRecords(cnt,limits,tagid){ 
       
	   $.ajax({
			url	 : "/contents/ajaxhome/"+limits+','+tagid,     
			data	 :  {'limits': limits},
			success	: function(sdata){ 
			 var lmt = limits + 6; 
			 $('.contentdiv').html(sdata);
			 if(cnt > lmt){ 
				$('#loadmore').html('<a href="javascript:void(0)" onclick="getMoreRecords('+cnt+','+lmt+','+tagid+')">Load more stories <i class="caret"></i></a>');
			}else{
				$('#loadmore').html('<a href="javascript:void(0)" onclick="getMoreRecords('+cnt+','+lmt+','+tagid+')">No More Records <i class="caret"></i></a>');
			}
		}
	  });
	}
 </script>
<?php $tagID=$this->params['pass'][0]; 
	if(!(is_numeric($tagID))){
		$taggName=$tagID;
			$tagNameId=$this->Common->getTagIdByName($tagID); 
			if(!empty($tagNameId)){$tagID = $tagNameId['Tag']['id'];}else{$tagID = '';} //echo 'Gautam'.$tagID;
	}else{$taggName='';}
	
?>

<section id="wrapper">
            <!--Content Start-->
            <section class="content">
                <section class="row">
                   <!--Left Start-->
    <section class="col-sm-8">
        <h2 class="head"><?php if(!(is_numeric($tagID))){echo $taggName;}else{echo $tagggName;}?> </h2>
        <section class="row products contentdiv recent-verified-post">
		<?php if(!empty($contents)){ //debug($contents);
				foreach($contents as $content){ 
				$postid = $content['Content']['id']; ?>
                <section class="col-sm-4 product">
                <!--p class="club-logo"><?php //echo $this->Html->image('home/barcelona-icon.png', array('alt' => ''));?></p-->
                <p class="productpic m-productpic">
					<?php
					  if(!empty($content['Photo'][0]['image'])){
							
						  if($content['Photo'][0]['image_type'] == 'file'){ 
								$image_name=$content['Photo'][0]['image'];
								echo '<a href=/post/'.$postid.'><img src="/timthumb.php?src=/img/photos/thumb/'.$image_name.'&h=191&w=236&zc=1"></a>';
						  }else{
								$image_name=$content['Photo'][0]['image'];
								echo '<a href=/post/'.$postid.'><img style="height:191px" src="'.$image_name.'"></a>';
						  }
					  }else{
                                          $video = $this->Common->get_videothumb($postid);
                                          if($video){
                                          $thumb = '<img src='.$video.' />';   
                                          }else{
                                          $thumb = '<img src="/timthumb.php?src=/img/photos/thumb/soccer-ball-128.png&h=191&w=236&zc=1">'; }
					  echo '<a href=/post/'.$postid.'>'.$thumb.'</a>';  
					  }
						//echo '<a href=/post/'.$postid.'><img src="/timthumb.php?src=/img/photos/thumb/soccer-ball-128.png&h=191&w=236&zc=1"></a>';
					
					?>
				</p>
                <h4><?php 
				if(!empty($content['Content']['title'])){$tag_content_title=substr($content['Content']['title'],0,50);}else{ $tag_content_title='';}
				echo $this->Html->link($tag_content_title, array('controller'=>'contents','action'=>'post_details',$postid,Inflector::slug($content['Content']['title'],'-')), array('escape' => false));
				?></h4>
                <section class="user-sec">
					<?php $user=$this->Common->getauser($content['Content']['user_id']); if(!empty($user)){?>
                                        <span class="userpic">
                                         <?php   if(!empty($user['User']['avatar_image'])){
                                            $img = $user['User']['avatar_image'];
                                             if (filter_var($img, FILTER_VALIDATE_URL) === FALSE) {
                                                  echo $this->Html->image('/img/avatar/' . $img ,array( 'url' => array('controller' => 'users', 'action' => 'profile_post',$user['User']['id'] )));
                                                }else{
                                                     echo $this->Html->image($img ,array( 'url' => array('controller' => 'users', 'action' => 'profile_post',$user['User']['id'] )));
                                                }
					      }else{
                                                    echo $this->Html->image('avatar/no_image.png',array( 'url' => array('controller' => 'users', 'action' => 'profile_post',$user['User']['id'] )));
					}     ?>     
                                            
                                            
					<?php // if(!empty($user['User']['avatar_image'])){ 
//							echo $this->Html->image('/img/avatar/'.$user['User']['avatar_image'], array('alt' => '','style'=>"max-width:10%"));
//						  }else{
//							echo $this->Html->image('/img/avatar/no_image.png', array('alt' => '','style'=>"max-width:10%"));
//						  }
						?>
					</span>
					<?php } ?>
                    <a href="<?php echo BASE_URL.'users/profile_post/'.$user['User']['id']; ?>"><span class="post-time"><strong><?php if(!empty($user)){ echo $user['User']['first_name'];} ?></strong></a></span> 
                                            <?php $creatd = $content['Content']['created']; $new_date = date('Y-m-d h:i:s');
					     $date1 = new DateTime(date('Y-m-d', strtotime($creatd)));
						  $date2 = new DateTime(date('Y-m-d', strtotime($new_date)));
						  $num_day=$date1->diff($date2)->days; 
						  if($num_day == '0'){ echo ' Today';}
						  else if($num_day == '1'){ echo ' '.$num_day.' day ago';}
						  else{echo ' '.$num_day.' days ago';}
					?>
					</span>
					</span>
                <!--span class="post-type"><?php //echo $this->Html->image('home/video.png', array('alt' => ''));?></span-->
                </section>
				
            </section>
            <?php } }else{echo 'No Post(s) related to '.$taggName.' Tag.';} ?>
			
        </section>
		<?php if($allcontents >= 9){?>
        <p class="loadmore" id="loadmore"><a href="javascript:void(0)" onclick="getMoreRecords(<?php echo $allcontents;?>,12,<?php echo $tagID;?>)">Load more stories <i class="caret"></i></a></p>
		<?php }else{echo '';} ?>
    </section>
    <!--Left Closed-->
                    <!--Right Start-->
                    <section class="col-sm-4 text-center">    
                    	<!--Add-Content-Start--> 
                        	<!--div class="add-block">
                       	    	<a href="javascript:void(0)"><img width="360" height="304" alt="" src="/img/add-pic1.png" title=""></a>
                            </div-->
                        <!--Add-Content-Closed--> 
						<iframe src="//www.facebook.com/plugins/likebox.php?href=https%3A%2F%2Fwww.facebook.com%2FFootyBaseCom&amp;width&amp;height=290&amp;colorscheme=light&amp;show_faces=true&amp;header=true&amp;stream=false&amp;show_border=true" scrolling="no" frameborder="0" style="border:none; overflow:hidden; height:290px;" allowTransparency="true"></iframe>
					<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- footybase2 -->
<ins class="adsbygoogle"
     style="display:inline-block;width:336px;height:280px"
     data-ad-client="ca-pub-2247586710150023"
     data-ad-slot="5316964004"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>
                    </section>
					
					
                    <!--Right Closed-->
                </section>
				
					
            </section>
            <!--Content Closed-->
     
