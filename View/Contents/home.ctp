<script>
  //hideControlOnEnd: true,
  //adaptiveHeight: true,
	function getMoreRecords(cnt,limits){ 
		$.ajax({
			url	 : "/contents/ajaxhome/"+limits,     
			data	 :  {'limits': limits},
			success	: function(sdata){ 
				 var lmt = limits + 6; 
				 $('.contentdiv').html(sdata);
				 if(cnt > lmt){ 
					$('#loadmore').html('<a href="javascript:void(0)" onclick="getMoreRecords('+cnt+','+lmt+')">Load more stories <i class="caret"></i></a>');
				}else{
					$('#loadmore').html('<a href="javascript:void(0)" onclick="getMoreRecords('+cnt+','+lmt+')">No More Records <i class="caret"></i></a>');
				}
			}
		});
	}
 </script>
        <!--Wrapper Start-->
        <section id="wrapper">
            <!--Content Start-->
            <section class="content popular_postclass">
			<!--Gallery Section Start-->
            	<section class="row">
                	<section class="col-xs-12">
                    	<h2 class="head">Popular Posts</h2>
                		<div class="gallery-section">
						
						<?php $count_loop1 = 1; $count_loop2 = 1; 
                     foreach($popular_posts as $popular_post){ 
							 if($count_loop1 == 1){ $popularss_content_id = $popular_post['Content']['id'] ?>
                          <div class="col-sm-7 gallery-col">
                       	  <div class="galllery-big-thumb">
                            <?php
									if (!empty($popular_post['Photo'][0]['image'])) {
									if ($popular_post['Photo'][0]['image_type'] == 'file'){
										$image_name = $popular_post['Photo'][0]['image'];
										echo '<a href="/post/'.$popular_post['Content']['id'].'"><img src="/timthumb.php?src=/img/photos/original/'.$image_name.'&h=426&w=662&zc=1" ></a>';
									}else{
										$image_name = $popular_post['Photo'][0]['image'];
										echo '<a href="/post/'.$popular_post['Content']['id'].'"><img src="'.$image_name.'"/></a>';
									}
								}else{
									   $video = $this->Common->get_videothumb($popularss_content_id); 
									   if($video){
									   echo  '<a href="/post/'.$popular_post['Content']['id'].'"><img src='.$video.' /></a>'; 
									   }else{
										  echo '<a href="/post/'.$popular_post['Content']['id'].'"><img src=/img/photos/original/soccer-ball-128.png></a>';
                              }   
								}
							?>
								
                            </div>
                            <section class="big-thumb-strip">
                                	<section class="big-thumb-rw">
                                    	<p><?php echo $this->Html->link($popular_post['Content']['title'],'/post/'.$popular_post['Content']['id']);?></p>
                                    </section>
                                    <section class="big-thumb-rw">
                                    	<section class="user-sec">
                                    <span class="userpic">
									<?php if(!empty($popular_post['User']['avatar_image'])){ 
									$img = $popular_post['User']['avatar_image'];
									if (filter_var($popular_post['User']['avatar_image'], FILTER_VALIDATE_URL) === FALSE) {
									   echo '<a href="/users/profile_post/'.$popular_post['User']['id'].'">'.$this->Html->image('/img/avatar/'.$img, array('alt' => '','style'=>"max-width:10%")).'</a>';
									   }else{
									   echo '<a href="/users/profile_post/'.$popular_post['User']['id'].'"><img style="max-width:10%" src='.$img.'></a>';
								   }
										//echo $this->Html->image('/img/avatar/'.$popular_post['User']['avatar_image'], array('alt' => '','style'=>"max-width:10%"));
                                                                                 }else{
										echo '<a href="/users/profile_post/'.$popular_post['User']['id'].'">'.$this->Html->image('/img/avatar/no_image.png', array('alt' => '','style'=>"max-width:10%")).'</a>';
									  }
									?>
									</span>
                                      <?php echo'<a href="/users/profile_post/'.$popular_post['User']['id'].'">'; ?><span class="post-time"><strong><?php if(!empty($popular_post['User'])){ echo $popular_post['User']['first_name'];} ?></strong></a> 
										<?php $creatd = $popular_post['Content']['created']; $new_date = date('Y-m-d h:i:s');
											 $date1 = new DateTime(date('Y-m-d', strtotime($creatd)));
											  $date2 = new DateTime(date('Y-m-d', strtotime($new_date)));
											  $num_day=$date1->diff($date2)->days; 
											  if($num_day == ' &nbsp;0'){ echo ' Today';}
											  else if($num_day == '&nbsp;1'){ echo ' '.$num_day.' day ago';}
											  else{echo '&nbsp;'. $num_day.' days ago';}
										?>
										</span>
                                </section>
                                    </section>
                                </section>
                        </div>
						<?php } $count_loop1++; } ?>
                        <div class="col-sm-5 gallery-col">
                        	<div class="galllery-small-thumb">
							<?php foreach($popular_posts as $popular_post_data){
							  if($count_loop2 > 1){ $sub_popularss_content_id = $popular_post_data['Content']['id'];?>
                           	   <div class="col-sm-6 col-xs-12 gallery-col gallery-col-thumb">
								<?php
									if (!empty($popular_post_data['Photo'][0]['image'])) {
									if ($popular_post_data['Photo'][0]['image_type'] == 'file') {
										$image_name = $popular_post_data['Photo'][0]['image'];
										echo '<a href="/post/'.$popular_post_data['Content']['id'].'"><img src="/timthumb.php?src=/img/photos/thumb/'.$image_name.'&h=191&w=236&zc=1"></a>';
									}else{
										$image_name = $popular_post_data['Photo'][0]['image'];
										echo '<a href="/post/'.$popular_post_data['Content']['id'].'"><img style="height:191px" src="'.$image_name.'"></a>';
									}
									}else{
                                                                            
									$video = $this->Common->get_videothumb($sub_popularss_content_id);
										if($video){
									   echo  '<a href="/post/'.$popular_post_data['Content']['id'].'"><img src='.$video.' /></a>'; 
									   }else{
										echo '<a href="/post/'.$popular_post_data['Content']['id'].'"><img src="/timthumb.php?src=/img/photos/thumb/soccer-ball-128.png&h=191&w=236&zc=1"></a>';
                                                                        }}
								?>
                                    <section class="small-thumb-strip">
                                    <p><?php if(!empty($popular_post_data['Content']['title'])){$sub_popular_title=substr($popular_post_data['Content']['title'],0,80);}else{ $sub_popular_title='';}
									echo $this->Html->link($sub_popular_title, '/post/'.$sub_popularss_content_id);
									?>
                                    
                                    
                                    </p>
                                    </section>
                              </div>
                               <?php   } $count_loop2++; } ?>
                               <div class="facebook-strip col-xs-12">
                               <iframe src="//www.facebook.com/plugins/like.php?href=https%3A%2F%2Fwww.facebook.com%2Fpages%2FFootyBase%2F838220629555711&amp;width&amp;layout=standard&amp;action=like&amp;show_faces=false&amp;share=false&amp;height=35px" class="add_social" scrolling="no" frameborder="0" style="border:none; overflow:hidden;" allowTransparency="true"></iframe>
                                   
                               </div>
                          </div>
                        </div>
						
                    </div>
                    </section>
                </section>
                <!--Gallery Section end-->
		
  <section class="row">
    <!--Left Start-->
    <section class="col-sm-12 col-md-8">
	<h2 class="head">Recent Posts</h2>
        <!--h2 class="head">Recent Verified <!--span style="float:right">
		<a href="javascript:void(0)" onclick="window.history.back()"><img alt="" src="/img/arrow-back-32.png"> Back</a></span--><!--/h2-->
        <section class="row products contentdiv recent-verified-post">
		<?php if(!empty($contents)){ //debug($contents);
				foreach($contents as $content){ 
				$postid = $content['Content']['id']; ?>
            <section class="col-sm-4 product">
                <!--p class="club-logo"><?php //echo $this->Html->image('home/barcelona-icon.png', array('alt' => ''));?></p-->
                <p class="productpic m-productpic">
					<?php
                                        //echo $content['Photo'][0]['image_type'];
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
						  $thumb = '<img src='.$video.'></a>';   
						  }else{
						  $thumb = '<img src="/timthumb.php?src=/img/photos/thumb/soccer-ball-128.png&h=191&w=236&zc=1">'; }
					     echo '<a href=/post/'.$postid.'>'.$thumb.'</a>';
					  }
					?>
				</p>
                 <h4><?php if(!empty($content['Content']['title'])){$recent_popular_title=substr($content['Content']['title'],0,80);}else{ $recent_popular_title='';}
				//echo $this->Html->link($recent_popular_title, array('controller'=>'contents','action'=>'post_details',$postid), array('escape' => false));
				echo $this->Html->link($recent_popular_title, '/post/'.$postid);?></h4>
                <section class="user-sec">
					<?php $user=$this->Common->getauser($content['Content']['user_id']); if(!empty($user)){?>
                    <span class="userpic">
			 		<?php if(!empty($user['User']['avatar_image'])){ 
								$img = $user['User']['avatar_image'];
							   if(filter_var($user['User']['avatar_image'], FILTER_VALIDATE_URL) === FALSE) {
								   echo '<a href="/users/profile_post/'.$content['User']['id'].'">'.$this->Html->image('/img/avatar/'.$img, array('alt' => '','style'=>"max-width:10%")).'</a>';
							   }else{
								 echo $this->Html->link($this->Html->image($img),array('controller' => 'users', 'action' => 'profile_post',$content['User']['id']), array('escape' => false));
						      }
						  }else{
							echo '<a href="/users/profile_post/'.$content['User']['id'].'>'.$this->Html->image('/img/avatar/no_image.png', array('alt' => '','style'=>"max-width:10%")).'</a>';
						  }
						?>
					</span>
					<?php } ?>            
                     <?php echo'<a href="/users/profile_post/'.$content['User']['id'].'">'; ?>
					 <span class="post-time"><strong><?php if(!empty($user)){ echo $user['User']['first_name'];} ?></strong> </a> <span style="color:#a6a6a6;">
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
            <?php } }else{echo 'No Post(s).';} ?>
			
        </section>
        <p class="loadmore" id="loadmore"><a href="javascript:void(0)" onclick="getMoreRecords(<?php echo $allcontents;?>,12)">Load more stories <i class="caret"></i></a></p>
    </section>
    <!--Left Closed-->
    <!--Right Start-->
    <section class="col-sm-4 new_ipad_left">
        <!--Trending Tags Start-->
        <section class="col-sm-12 module">
            <h2>Trending Tags</h2>
            <section class="tags-widget clearfix">
				<?php $alltagsums=$this->Common->getRightmenuTags(); 
				if(!empty($alltagsums)){ $cnt = 1;
				foreach($alltagsums as $alltagsum){ 
					$tagname = $alltagsum['Tag']['tag_name'];
					$count_tag = $alltagsum[0]['entity_count']; 
					if(($cnt == 4) || ($cnt == 5)){ $span ='<span class="countlabel"><strong>'.$cnt.'</strong></span>';
					}else{ $span ='<span class="countlabel medal">'.$this->Html->image('home/medal_'.$cnt.'.png', array('alt' => '')).'</span> ';}
				?>
                <a href="/tag/<?php echo ucfirst($tagname);?>"><?php echo $span;?><span class="teamname"><?php echo ucfirst($tagname);?></span> <span class="pull-right"><?php echo $this->Html->image('home/tagImage_'.$cnt.'.png', array('alt' => ''));?></span></a>
				<?php $cnt++;} } ?>
            </section>
        </section>
        <!--Trending Tags Closed-->
        
        <!--Related Content Start-->
        <!--section class="col-sm-12 module graybox">
            <h2>Related Content</h2>
            <ul class="relatedlist">
			<?php /*$allvideos=$this->Common->getAllVideoByContentId(); if(!empty($allvideos)){
			foreach($allvideos as $allvideo){
			$string=$allvideo['Video']['video_url'];
			$doc = new DOMDocument();
			@$doc->loadHTML($string);
			$tags = $doc->getElementsByTagName('iframe');
			foreach ($tags as $tag) {  $src= $tag->getAttribute('src'); */?>
				<li>
                    <p><iframe width="320" height="315" frameborder="0" allowfullscreen="" src="<?php echo $src;?>"></iframe></p>
                </li>
			<?php /*}*/?>
               
			<?php /*} }*/ ?>
            </ul>
        </section-->
        <!--Related Content Closed-->
		<div class="text-center">
		<iframe src="//www.facebook.com/plugins/likebox.php?href=https%3A%2F%2Fwww.facebook.com%2FFootyBaseCom&amp;width&amp;height=290&amp;colorscheme=light&amp;show_faces=true&amp;header=true&amp;stream=false&amp;show_border=true" scrolling="no" frameborder="0" style="border:none; overflow:hidden; height:290px;" allowTransparency="true"></iframe>
		<div data-type="standing" data-id="64794" id="wgt-64794" class="tap-sport-tools" style="width:340px; height:auto;"></div>
<div id="wgt-ft-64794" style="width:336px;"><p>Standings provided by <a href="http://www.whatsthescore.com" target="_blank" rel="nofollow"><img src="http://medias.whatsthescore.com/upload/logo-s.png" alt="whatsthescore.com" /></a></p></div><style type="text/css">#wgt-ft-64794  {background:#FFFFFF !important;color:#484848 !important;text-decoration:none !important;padding:4px 2px !important;margin:0 !important;}#wgt-ft-64794 * {font:10px Arial !important;}#wgt-ft-64794 a {color:#484848 !important;}#wgt-ft-64794 img {vertical-align:bottom !important;height:15px !important;}</style><script type="text/javascript" src="http://tools.whatsthescore.com/load.min.js?242"></script> </div>

    </section>
    <!--Right Closed-->
</section>
 
                </section>
           
           